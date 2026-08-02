/**
 * DEDICATED GIS MAP SCRIPT FOR KALIMANTAN SELATAN
 * Sleek Vector SVG Pin Markers & Dynamic Panning
 * UPTD Balatkop & UKM Provinsi Kalimantan Selatan
 */

(function () {
    let mapInstance = null;
    let markersLayer = null;
    let markersMap = {};
    let initialBounds = null;

    window.initGisMap = function (mapData, livewireComponent) {
        const mapContainer = document.getElementById('gisMap');
        if (!mapContainer) return;

        // Reset previous map instance if re-rendered
        if (mapInstance !== null) {
            mapInstance.remove();
            mapInstance = null;
        }

        markersMap = {};

        // South Kalimantan Center Coordinates & Zoom
        const kalselCenter = [-2.95, 115.35];

        mapInstance = L.map('gisMap', {
            center: kalselCenter,
            zoom: 8.5,
            minZoom: 7.5,
            maxZoom: 14,
            zoomControl: true,
            scrollWheelZoom: false
        });

        window.gisMapInstance = mapInstance;

        // OpenStreetMap Tile Layer (Natural Blue Water & Green Terrain)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors | Balatkop-uk Prov. Kalsel'
        }).addTo(mapInstance);

        markersLayer = L.layerGroup().addTo(mapInstance);

        // Fit bounds to cover all 13 regencies/cities
        const latLngBounds = L.latLngBounds();

        // Render Location Pin Markers for 13 Regencies/Cities
        mapData.forEach(region => {
            if (!region.latitude || !region.longitude) return;

            const lat = parseFloat(region.latitude);
            const lng = parseFloat(region.longitude);
            latLngBounds.extend([lat, lng]);

            const isKota = region.jenis === 'kota';
            const pinColor = isKota ? '#0284c7' : '#16a34a';

            // Custom Vector SVG Location Pin Icon (100% Perfectly Centered Dot & Clean Pill Label)
            const customIcon = L.divIcon({
                className: 'gis-custom-svg-pin',
                html: `
                    <div class="gis-svg-pin-wrapper" id="pin-marker-${region.id_wilayah}">
                        <svg width="30" height="40" viewBox="0 0 34 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="gis-pin-svg">
                            <path d="M17 0C7.61116 0 0 7.61116 0 17C0 29.75 17 44 17 44C17 44 34 29.75 34 17C34 7.61116 26.3888 0 17 0Z" fill="${pinColor}" stroke="#FFFFFF" stroke-width="2.5"/>
                            <circle cx="17" cy="17" r="6" fill="#FFFFFF"/>
                        </svg>
                        <div class="gis-pin-pill-label">${region.nama}</div>
                    </div>
                `,
                iconSize: [120, 62],
                iconAnchor: [60, 40]
            });

            const marker = L.marker([lat, lng], { icon: customIcon }).addTo(markersLayer);
            markersMap[region.id_wilayah] = marker;

            // Rich Tooltip on Hover
            const tooltipContent = `
                <div style="font-weight: 800; font-size: 0.88rem; color: #0f172a;">${region.nama}</div>
                <div style="font-size: 0.76rem; color: #64748b;">${isKota ? 'Kota' : 'Kabupaten'} &bull; Kode BPS: ${region.kode_bps || '-'}</div>
                <div style="font-size: 0.76rem; color: #0284c7; font-weight: 700; margin-top: 2px;">
                    ${(region.responden || 0).toLocaleString()} Responden &bull; ${(region.peserta || 0).toLocaleString()} Alumni
                </div>
            `;
            marker.bindTooltip(tooltipContent, {
                permanent: false,
                direction: 'top',
                offset: [0, -35]
            });

            // Handle Click: Select Region & Scroll
            marker.on('click', function () {
                mapInstance.setView([lat, lng], 10, { animate: true });
                if (livewireComponent && region.id_wilayah) {
                    livewireComponent.selectWilayah(region.id_wilayah);
                    setTimeout(() => {
                        const detailSec = document.getElementById('regionDetailSection');
                        if (detailSec) {
                            detailSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }, 200);
                }
            });
        });

        if (mapData.length > 0) {
            initialBounds = latLngBounds;
            mapInstance.fitBounds(latLngBounds, { padding: [40, 40] });
        }

        window.gisMarkersMap = markersMap;
        window.gisInitialBounds = initialBounds;
    };

    // LISTEN FOR SIDEBAR SELECTION EVENT
    window.addEventListener('focusWilayahOnMap', event => {
        const data = Array.isArray(event.detail) ? event.detail[0] : event.detail;
        if (data && data.latitude && data.longitude && mapInstance) {
            mapInstance.setView([parseFloat(data.latitude), parseFloat(data.longitude)], 11, {
                animate: true,
                duration: 1.2
            });

            if (markersMap[data.id_wilayah]) {
                markersMap[data.id_wilayah].openTooltip();
            }
        }
    });

    // LISTEN FOR RESET FILTER EVENT
    window.addEventListener('resetMapZoom', () => {
        if (mapInstance && initialBounds) {
            mapInstance.fitBounds(initialBounds, { padding: [40, 40] });
        }
    });
})();

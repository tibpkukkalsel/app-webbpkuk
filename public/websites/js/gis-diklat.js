/**
 * DEDICATED GIS MAP SCRIPT FOR KALIMANTAN SELATAN
 * Sleek Vector SVG Pin Markers & Smooth Dynamic Zoom Animation
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

        // Create Leaflet map instance once if not created yet
        if (mapInstance === null) {
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

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors | Balatkop-uk Prov. Kalsel'
            }).addTo(mapInstance);

            markersLayer = L.layerGroup().addTo(mapInstance);
        } else {
            markersLayer.clearLayers();
        }

        markersMap = {};
        const latLngBounds = L.latLngBounds();

        // Render Location Pin Markers for 13 Regencies/Cities
        mapData.forEach(region => {
            if (!region.latitude || !region.longitude) return;

            const lat = parseFloat(region.latitude);
            const lng = parseFloat(region.longitude);
            latLngBounds.extend([lat, lng]);

            const isKota = region.jenis === 'kota';
            const pinColor = isKota ? '#0284c7' : '#16a34a';

            // Custom Vector SVG Location Pin Icon
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
                <div style="font-weight: 800; font-size: 0.92rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 6px;">${region.nama}</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px 10px; font-size: 0.75rem; text-align: left;">
                    <div><span style="color: #64748b;">Responden:</span> <strong style="color: #0284c7;">${(region.responden || 0).toLocaleString('id-ID')}</strong></div>
                    <div><span style="color: #64748b;">Kebutuhan:</span> <strong style="color: #0891b2;">${(region.kebutuhan || 0).toLocaleString('id-ID')}</strong></div>
                    <div><span style="color: #64748b;">Target:</span> <strong style="color: #d97706;">${(region.target || 0).toLocaleString('id-ID')}</strong></div>
                    <div><span style="color: #64748b;">Realisasi:</span> <strong style="color: #16a34a;">${(region.realisasi || 0).toLocaleString('id-ID')}</strong></div>
                </div>
            `;
            marker.bindTooltip(tooltipContent, {
                permanent: false,
                direction: 'top',
                offset: [0, -35]
            });

            // Handle Click: FlyTo Zoom & Select Region & Scroll
            marker.on('click', function () {
                mapInstance.flyTo([lat, lng], 11, { duration: 1.2 });
                if (livewireComponent && region.id_wilayah) {
                    livewireComponent.selectWilayah(region.id_wilayah);
                    setTimeout(() => {
                        const detailSec = document.getElementById('regionDetailSection');
                        if (detailSec) {
                            detailSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }, 300);
                }
            });
        });

        if (mapData.length > 0 && !initialBounds) {
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
            const lat = parseFloat(data.latitude);
            const lng = parseFloat(data.longitude);

            mapInstance.flyTo([lat, lng], 11, {
                duration: 1.2
            });

            if (markersMap && markersMap[data.id_wilayah]) {
                setTimeout(() => {
                    markersMap[data.id_wilayah].openTooltip();
                }, 700);
            }

            setTimeout(() => {
                const detailSec = document.getElementById('regionDetailSection');
                if (detailSec) {
                    detailSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 300);
        }
    });

    // LISTEN FOR RESET FILTER EVENT
    window.addEventListener('resetMapZoom', () => {
        if (mapInstance && initialBounds) {
            mapInstance.fitBounds(initialBounds, { padding: [40, 40] });
        }
    });
})();

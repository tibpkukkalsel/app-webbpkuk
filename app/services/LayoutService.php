<?php

namespace App\Services;

use App\Models\Footer;
use App\Models\Identitas;
use Illuminate\Support\Facades\Cache;

class LayoutService
{
    /**
     * Get all identity data.
     */
    public function getIdentitas()
    {
        return Identitas::all();
    }

    /**
     * Get all footer data.
     */
    public function getFooter()
    {
        return Footer::all();
    }

    /**
     * Get layout data bundle for frontend views.
     */
    public function getLayoutData(): array
    {
        return [
            'identitas' => $this->getIdentitas(),
            'footer'    => $this->getFooter(),
        ];
    }

    /**
     * Clear layout cache if needed.
     */
    public function clearCache(): void
    {
        Cache::forget('website_identitas');
        Cache::forget('website_footer');
    }
}

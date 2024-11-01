<?php

namespace bs\Flatpickr\assets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

class FlatpickrAsset extends AssetBundle
{
    // Set the base source path to the extension directory
    public $sourcePath = '@vendor/beaten-sect0r/yii2-flatpickr/src';
    public $locale;
    public $plugins = [];
    public $theme;

    // Separate bundle for flatpickr core files
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        // Add core flatpickr files
        $this->js = [
            '//cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js', // Or use local path if preferred
        ];
        $this->css = [
            '//cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', // Or use local path if preferred
        ];
    }

    public function registerAssetFiles($view)
    {
        // language
        if ($this->locale !== null && $this->locale !== 'en') {
            $this->js[] = '//cdn.jsdelivr.net/npm/flatpickr/dist/l10n/' . $this->locale . '.js';
        }

        // plugin
        if (!empty($this->plugins) && is_array($this->plugins)) {
            if (ArrayHelper::keyExists('rangePlugin', $this->plugins)) {
                $this->js[] = '//cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js';
            }
            if (ArrayHelper::keyExists('confirmDate', $this->plugins)) {
                // Use local confirmDate.js from extension
                $this->js[] = 'js/confirmDate.js';
                $this->css[] = '//cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.css';
            }
            if (ArrayHelper::isIn('label', $this->plugins)) {
                $this->js[] = '//cdn.jsdelivr.net/npm/flatpickr/dist/plugins/labelPlugin/labelPlugin.js';
            }
            if (ArrayHelper::keyExists('weekSelect', $this->plugins)) {
                $this->js[] = '//cdn.jsdelivr.net/npm/flatpickr/dist/plugins/weekSelect/weekSelect.js';
            }
        }

        // theme
        if (!empty($this->theme)) {
            $this->css[] = '//cdn.jsdelivr.net/npm/flatpickr/dist/themes/' . $this->theme . '.css';
        }

        parent::registerAssetFiles($view);
    }
}
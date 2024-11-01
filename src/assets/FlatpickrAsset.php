<?php

namespace bs\Flatpickr\assets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

class FlatpickrAsset extends AssetBundle
{
    // Set both source paths
    public $flatpickrPath = '@bower/flatpickr/dist';
    public $sourcePath = '@vendor/beaten-sect0r/yii2-flatpickr/src';

    public $locale;
    public $plugins = [];
    public $theme;

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        $this->js = [
            Yii::getAlias($this->flatpickrPath) . '/flatpickr.min.js',
        ];
        $this->css = [
            Yii::getAlias($this->flatpickrPath) . '/flatpickr.min.css',
        ];
    }

    public function registerAssetFiles($view)
    {
        // language
        if ($this->locale !== null && $this->locale !== 'en') {
            $this->js[] = Yii::getAlias($this->flatpickrPath) . '/l10n/' . $this->locale . '.js';
        }

        // plugin
        if (!empty($this->plugins) && is_array($this->plugins)) {
            if (ArrayHelper::keyExists('rangePlugin', $this->plugins)) {
                $this->js[] = Yii::getAlias($this->flatpickrPath) . '/plugins/rangePlugin.js';
            }
            if (ArrayHelper::keyExists('confirmDate', $this->plugins)) {
                // Local confirmDate.js
                $this->js[] = 'js/confirmDate.js';
                $this->css[] = Yii::getAlias($this->flatpickrPath) . '/plugins/confirmDate/confirmDate.css';
            }
            if (ArrayHelper::isIn('label', $this->plugins)) {
                $this->js[] = Yii::getAlias($this->flatpickrPath) . '/plugins/labelPlugin/labelPlugin.js';
            }
            if (ArrayHelper::keyExists('weekSelect', $this->plugins)) {
                $this->js[] = Yii::getAlias($this->flatpickrPath) . '/plugins/weekSelect/weekSelect.js';
            }
        }

        // theme
        if (!empty($this->theme)) {
            $this->css[] = Yii::getAlias($this->flatpickrPath) . '/themes/' . $this->theme . '.css';
        }

        parent::registerAssetFiles($view);
    }
}
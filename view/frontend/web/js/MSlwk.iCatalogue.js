define(
    [
        'jquery',
        'turnjs'
    ], function ($) {
        'use strict';

        var init;

        init = function (config) {
            $('.flipbook').turn({
                width: config.width,
                height: config.height,
                elevation: 50,
                gradients: true,
                autoCenter: false
            });

        };

        return init;
    }
);




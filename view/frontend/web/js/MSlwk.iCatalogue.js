define(
    [
        'jquery',
        'turnjs'
    ], function ($) {
        'use strict';

        var init;

        init = function (config, element) {
            $(element).turn({
                width: config.width,
                height: config.height,
                elevation: 50,
                gradients: true,
                autoCenter: false
            });
            $(window).bind('keydown', function (e) {
                if (e.keyCode === 37)
                    $(element).turn('previous');
                else if (e.keyCode === 39)
                    $(element).turn('next');
            });
        };

        return init;
    }
);




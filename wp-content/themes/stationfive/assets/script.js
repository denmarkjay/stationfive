import "./js/popper.1.14.0.min";
import counterUp from "./js/jquery-count";
import "bootstrap";

/**
 * Bind event on ready state when the application finished loading.
 */
$(document).on('ready', function () {
    /**
     * This method add comma to any numbers.
     *
     * @param {number} nStr 
     * @returns string
     */
    function addCommas(nStr){
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        return x1 + x2;
    }

    /**
     * Start the animation.
     */
    counterUp($('.animate-count')[0], {
        duration: 1500,
        delay: 40,
        callback: function(data) {
            var value = parseFloat(data.replace(/,/g, ""));

            if (value > 0) {
                var figureToReach = parseInt($('#donation-total-figure').val());
                var percentage = value / figureToReach;

                $('.bar span').width((percentage * 100)+'%');
            }
        }
    });

    /**
     * Add custom event on the amount field to customize 
     * the displayed format.
     */
    $('#donation-amount').on('blur', function() {
        if (this.value.replace(/ /g, '') != '') {
            var el = $(this);
            var val = this.value;

            setTimeout( function() {
                val = parseFloat(val).toFixed(2);
                el.val(val);
            }, 10);
        }
    }).on('input change, keyup', function() {
        var val = this.value;
        val = parseFloat(val).toFixed(2);

        $('.total-mirror').text(val);
    }).trigger('blur');
});
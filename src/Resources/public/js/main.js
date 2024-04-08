//Deshabilitanto el inicio automatico de dropzone
Dropzone.autoDiscover = false;

$(function() {
    "use strict";

    // DateTimePicker
    $(".datetimepicker").each(function() {
        var $input = $(this);
        var locale = $input.data("date-locale");
        var step = $input.data("date-step");
        jQuery.datetimepicker.setLocale(locale);
        $input.datetimepicker({
            format: "d/m/Y H:i",
            step: step
        });
    });

    $(".js-btn-datetimepicker-show").on("click", function(event) {
        var $btn = $(event.currentTarget);
        var $input = $btn
            .parent()
            .parent()
            .find(".datetimepicker");
        $input.datetimepicker("toggle");
    });

    $(".js-btn-datetimepicker-reset").on("click", function(event) {
        var $btn = $(event.currentTarget);
        var $input = $btn
            .parent()
            .parent()
            .find(".datetimepicker");
        $input.val("");
    });

    // Botton Reset of DatePicker and DatetimePicker
    $(".js-btn-date-reset").on("click", function(event) {
        var $btn = $(event.currentTarget);
        var $input = $btn
            .parent()
            .parent()
            .find(".form-control");
        $input.val("");
    });

    // Button show DatePicker
    $(".js-btn-datepicker-show").on("click", function(event) {
        var $btn = $(event.currentTarget);
        var $input = $btn
            .parent()
            .parent()
            .find(".form-control");

        $input.datepicker("show");
    });
});

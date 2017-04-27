$(document).ready(function() {

    $('input[name=AMOUNT]').on('blur, change', function() {
        var amount = $('input[name=AMOUNT]').val().replace(/^\s+|\s+$/g, '');
        if (($('input[name=AMOUNT]').val() != '') && (!amount.match(/^$/))) {
            $('input[name=AMOUNT]').val(parseInt(amount).toFixed(3));

            $('.list-radios-amount .radio input[type=radio]').each(function() {
                if (amount != $(this).val()) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            });
        }
    });

    $('.list-radios-amount .radio input[type=radio]').on('change', function() {
        var RadioVal = $(this).val().replace(/^\s+|\s+$/g, '');
        if ((RadioVal != '') && (!RadioVal.match(/^$/))) {
            $('input[name=AMOUNT]').val(parseInt(RadioVal).toFixed(3));
        }
    });

    $('select[name=CURRENCY]').on('change', function() {
        var currency = $(this).val();
        $(".labCurrency").html(currency);
    });


    $("#submit_smt_payment_form").click(function() {
        var formId = $(this).closest("form").attr("id");
        var formData = $(this).closest("form").serialize();
        var formValid = true;


        $("#" + formId + " :input[required]").each(function() {
            if ($.trim($(this).val()) == "") {
                $(this).addClass("redborder");
                formValid = false;
            } else {
                $(this).removeClass("redborder");
            }
        });

        if (formValid) {
            $.post(
                ajaxurl, {
                    'action': 'Savedonation',
                    'data': formData
                },
                function(response) {
                    console.log(response);
                    $("input[name=VERIFICATION_CODE]").val(response["VERIFICATION_CODE"]);
                    if (response["ID"] > 0 && $("input[name=VERIFICATION_CODE]").val() != "" && $("input[name=VERIFICATION_CODE]").val() == response["VERIFICATION_CODE"] && $("input[name=AMOUNT]").val() != "" && $("input[name=AMOUNT]").val() != 0) {
                        setTimeout($("#" + formId).submit(), 5000);
                    } else {
                        sweetAlert("Oops...", "Quelque-chose s'est mal passé!", "error");
                    }
                }, "json");

        } else {
            sweetAlert("Oops...", "Veuillez svp remplir les champs obligatoires! Merci.", "error");
        }

        return false;
    });
});
$(document).ready(function () {
    $('.grid').masonry({
        // options
        itemSelector: '.post-item'
    });

    $('.datepicker.date').datepicker({
        format: "dd.mm.yy",
        maxViewMode: 2,
        clearBtn: true,
        autoclose: true,
        orientation: "top auto",
        todayHighlight: true
    });

    $('.timepicker').timepicker();


    var form = $('#nnk-booking-form');
    var wizard = $('#smartwizard');
    wizard.smartWizard(
        {
            toolbarSettings: {
                toolbarExtraButtons: [
                    $('<button></button>').text('Finish')
                        .addClass('btn btn-info')

                    ]
            }

        });
    wizard.show();
    wizard.on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
        if(stepDirection != "backward"){
            var result = form.valid();
            return result;
        }
    });

    form.validate({
        rules: {
            room: {
                required: true
            },
            date: {
                required: true
            },
            time_from: {
                required: true
            },
            time_until: {
                required: true
            },
            participants_num: {
                required: true,
                max: 35
            },
            purpose: {
                required: true,
                maxlength: 255
            },
            info: {
                maxlength: 255
            },
            firstname: {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            lastname: {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            address: {
                required: true,
                maxlength: 255
            },
            phone: {
                required: true,
                maxlength: 12
            },
            email: {
                required: true,
                email: true,
                maxlength: 60
            },
            rules:{
              required: true
            }
        },
        messages: {
            room: {
                required: 'See väli on kohustuslik'
            },
            date: {
                required: 'See väli on kohustuslik'
            },
            time_from: {
                required: 'See väli on kohustuslik'
            },
            time_until: {
                required: 'See väli on kohustuslik'
            },
            participants_num: {
                required: 'See väli on kohustuslik',
                max: 'Ruumis võib olla maksimaalselt 35 inimest'
            },
            purpose: {
                required: 'See väli on kohustuslik',
                maxlength: 'Tekst ei tohi olla pikkem kui 255 sübmolit'
            },
            info: {
                maxlength: 'Tekst ei tohi olla pikkem kui 255 sübmolit'
            },
            firstname: {
                required: 'See väli on kohustuslik',
                minlength: 'Nime pikkus ei tohi olla alla 2 sümbolit',
                maxlength: 'Nimi ei tohi olla pikkem kui 20 sübmolit'
            },
            lastname: {
                required: 'See väli on kohustuslik',
                minlength: 'Perekonnanime pikkus ei tohi olla alla 2 sümbolit',
                maxlength: 'Nimi ei tohi olla pikkem kui 20 sübmolit'
            },
            address: {
                required: 'See väli on kohustuslik',
                maxlength: 'Aadress ei tohi olla pikkem kui 100 sübmolit'
            },
            phone: {
                required: 'See väli on kohustuslik',
                max: 'Telefoninumber ei tohi olla pikkem kui 12 sümbolit'
            },
            email: {
                required: 'See väli on kohustuslik',
                email: 'Palun sisestage valiidne email',
                maxlength: 'Eemail võib olla mitte rohkem kui 60 sümbolit pikk'
            },
            rules: {
                required: 'Peate kinnitama, et olete lugenud meie reegleid ja olete nendega nõus'
            }
        }
    });
});

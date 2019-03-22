$(document).ready(function () {
    $('.grid').masonry({
        // options
        itemSelector: '.post-item'
    });

    var disabledDays = [0, 1];
    $('.datepicker-here').datepicker({
        format: "dd.mm.yy",
        maxViewMode: 2,
        clearBtn: true,
        autoClose: true,
        orientation: "top auto",
        todayHighlight: true,
        minDate: moment().add(7, 'days').toDate(),
        onSelect: function (formattedDate, date, inst) {
            if (status === 'overViewExist') {
                status = 'dataChanged';
            }
        },
        onRenderCell: function (date, cellType) {
            if (cellType == 'day') {
                var day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) != -1;

                return {
                    disabled: isDisabled
                }
            }
        }
    });

    $('.time').mask('AB:CD', {
        translation: {
            'A': {
                pattern: /[0-2]/, optional: true
            },
            'B': {
                pattern: /[0-9]/, optional: true
            },
            'C': {
                pattern: /[0-5]/, optional: true
            },
            'D': {
                pattern: /[0-9]/, optional: true
            }
        },
        onKeyPress: function (a, b, c, d) {
            let m = a.match(/(\d{1})/g);
            if (parseInt(m[0]) === 2) {
                d.translation.B.pattern = /[0-3]/;
            } else {
                d.translation.B.pattern = /[0-9]/;
            }
            let temp_value = c.val();
            c.val('');
            c.unmask().mask('AB:CD', d);
            c.val(temp_value);
        }
    });


    var form = $('#nnk-booking-form');
    var wizard = $('#smartwizard');
    var preloader = $('.preloader');
    var container = $("#totalSumma");
    var status = 'init';


    $("form :input").change(function () {
        if (status === 'overViewExist') {
            status = 'dataChanged';
        }

    });

    wizard.smartWizard({
        useURLhash: false,
        showStepURLhash: false

    });

    var buttonNext = $('.sw-btn-next');
    wizard.show();
    preloader.hide();
    wizard.on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {


        var result = form.valid();
        if (result && stepNumber === 1) {
            var allItems = JSON.parse(localStorage.getItem("times"));
            var timeFrom = $('input[name=time_from]').val();
            var timeTo = $('input[name=time_until]').val();
            timeFrom = moment($('input#date').val() + " " + timeFrom, "DD.MM.YYYY HH:ii");
            timeTo = moment($('input#date').val() + " " + timeTo, "DD.MM.YYYY HH:ii");
            $.each(allItems, function (index, item) {
                if (moment(item.start).isBetween(timeFrom, timeTo) || moment(item.end).isBetween(timeFrom, timeTo)
                    || moment(timeFrom).isBetween(item.start, item.end) || moment(timeTo).isBetween(item.start, item.end)) {
                    alert("Palun sisestage aeg, mis ei kattu olemas olevate broneeringutega");
                    result = false;
                    return false;
                }

            })
        } else if (stepNumber === 5) {
            buttonNext.show();
        }
        return result;

    });

    wizard.on("showStep", function (e, anchorObject, stepNumber, stepDirection) {

        if (stepNumber === 1) {
            var timetable = $('.timetable');
            timetable.fullCalendar({
                header: {
                    left: 'title',
                    center: '',
                    right: ''
                },
                timeFormat: 'HH:mm',
                height: 150,
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                defaultDate: moment($('input#date').val(), "DD.MM.YYYY"),
                defaultView: 'timelineDay',
                minTime: "10:00",
                maxTime: "19:00"
            });

            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'room_booking_time',
                    date: $('input#date').val(),
                    room: $('input[name=room]:checked').val()
                },
                method: 'POST'
            }).done(function (response) {
                var items = [];
                $.each(response.data.result, function (index, value) {
                    timetable.fullCalendar('renderEvent', {
                        id: index,
                        title: value.title,
                        start: moment(value.from.date),
                        end: moment(value.to.date)
                    });
                    items.push({
                        title: value.title,
                        start: moment(value.from.date),
                        end: moment(value.to.date)
                    });
                });
                localStorage.setItem("times", JSON.stringify(items));


            }).fail(function (response) {
                alert('error');
            });
        } else if (stepNumber === 5) {
            buttonNext.hide();
            if (status === 'init' || status === 'dataChanged') {
                preloader.show();
                var checkboxes = document.getElementsByName('resources[]');
                var vals = [];
                for (var i = 0, n = checkboxes.length; i < n; i++) {
                    if (checkboxes[i].checked) {
                        vals.push(checkboxes[i].value);
                    }
                }
                var dataForm = {
                    date: $('input#date').val(),
                    room: $('input[name=room]:checked').val(),
                    timeFrom: $('input#timeFrom').val(),
                    timeUntil: $('input#timeUntil').val(),
                    resources: vals,
                    participants: $('input#participants').val(),
                    purpose: $('input#purpose').val(),
                    info: $('textarea#info').val(),
                    firstName: $('input#firstname').val(),
                    lastName: $('input#lastname').val(),
                    phone: $('input#phone').val(),
                    email: $('input#email').val(),
                    address: $('input#address').val(),
                };

                $.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'filled_form',
                        form: dataForm
                    },
                    method: 'POST'
                }).done(function (response) {
                    status = 'overViewExist';
                    container.html(response.data.confirmationHTML);
                    preloader.hide();

                    $('.bookingFormSubmitButton').on('click', function () {
                        var checkboxes = document.getElementsByName('resources[]');
                        var vals = [];
                        for (var i = 0, n = checkboxes.length; i < n; i++) {
                            if (checkboxes[i].checked) {
                                vals.push(checkboxes[i].value);
                            }
                        }
                        var dataForm = {
                            date: $('input#date').val(),
                            room: $('input[name=room]:checked').val(),
                            timeFrom: $('input#timeFrom').val(),
                            timeUntil: $('input#timeUntil').val(),
                            resources: vals,
                            participants: $('input#participants').val(),
                            purpose: $('input#purpose').val(),
                            info: $('textarea#info').val(),
                            firstName: $('input#firstname').val(),
                            lastName: $('input#lastname').val(),
                            phone: $('input#phone').val(),
                            email: $('input#email').val(),
                            address: $('input#address').val(),
                        };

                        $.ajax({
                            url: ajaxurl,
                            data: {
                                action: 'booking_submit',
                                form: dataForm
                            },
                            method: 'POST'
                        }).done(function (response) {
                            $('.booking-form').html(response.data.submitSucces);

                        }).fail(function (response) {
                            //show error to client user friendly
                            console.log('error');
                            console.log(response);
                        });
                    });


                    console.log('success');
                    console.log(response);
                }).fail(function (response) {
                    console.log('error');
                    console.log(response);
                });
            }
        }
    });


    form.validate({
        errorContainer: "#messageBox1",
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
            rules: {
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

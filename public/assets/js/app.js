require('./bootstrap')
var Vue = require('vue');

import Echo from 'laravel-echo'


window.e = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
})

e.channel('test')
.listen('NotifyConfirmation', (e) => {
    toastr.info(Date.now(),'Notification',{
        "positionClass": "toast-down-right",
        timeOut: 55000,
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": false
    })
})
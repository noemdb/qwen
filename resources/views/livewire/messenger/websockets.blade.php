@section('websockets')
@parent

<script>
    // document.addEventListener('DOMContentLoaded', () => {
    //     if (window.Echo) {
    //         window.Echo.channel('chat')
    //             .listen('MessageSent', (event) => {
    //                 console.log('Nuevo mensaje recibido:', event);
    
    //                 // Muestra una notificación visual
    //                 Swal.fire({
    //                     title: 'Nuevo mensaje',
    //                     text: `${event.user.name}: ${event.message.content}`,
    //                     icon: 'info',
    //                     toast: true,
    //                     position: 'top-right',
    //                     showConfirmButton: false,
    //                     timer: 3000,
    //                     timerProgressBar: true,
    //                 });
    //             });
    //     } else {
    //         console.error('window.Echo no está definido');
    //     }
    // });

    

    document.addEventListener('DOMContentLoaded', () => {
        let userId = @json(auth()->id());
        console.log('ID del usuario:', userId);
        console.log(Echo.connector);

        if (!userId) {
            console.error('No se encontró el ID del usuario.');
            return;
        }

        if (window.Echo) {
            //let channel = 'private-chat.' + userId;

            // console.log('Laravel Echo está disponible. En el canal: ' + channel);

            // // window.Echo.private('private-chat.' + userId)
            // window.Echo.private(channel)
            //     .listen('MessageSent', (event) => {
                    
            //         console.log('Nuevo mensaje recibido:', event);

            //         if (event && event.message) {
            //             Swal.fire({
            //                 title: 'Nuevo mensaje',
            //                 text: event.message,
            //                 icon: 'info'
            //             });
            //         } else {
            //             console.warn('El evento no tiene datos de mensaje.');
            //         }
            //     });


            let channel = 'chat.' + userId;
            window.Echo.private(channel)
            .listen('.MessageSent', (event) => {
                console.log('Evento recibido en el canal:', channel);
                console.log('Datos del evento:', event);

                if (event && event.message) {
                    Swal.fire({
                        title: 'Nuevo mensaje',
                        text: event.message,
                        icon: 'info'
                    });
                } else {
                    console.warn('El evento no tiene datos de mensaje.');
                }
            })
            .error((error) => {
                console.log('channel: '+channel);
                console.error('Error en el canal:', error);
            });

        } else {
            console.error('window.Echo no está definido');
        }

        // let channel = 'chat.' + userId;
        // window.Echo.private(channel)
        //     .listen('MessageSent', (event) => {
        //         console.log('Datos del evento:', event);
        //         if (event && event.message) {
        //             Swal.fire({
        //                 title: 'Nuevo mensaje',
        //                 text: event.message,
        //                 icon: 'info'
        //             });
        //         } else {
        //             console.warn('El evento no tiene datos de mensaje.');
        //         }
        //     })
        //     .error((error) => {
        //         console.error('Error en el canal:', error);
        //     });

    });



</script>

@endsection
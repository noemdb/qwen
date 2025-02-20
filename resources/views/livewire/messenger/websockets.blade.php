@section('websockets')
@parent

<script>

    document.addEventListener('DOMContentLoaded', () => {

        let userId = @json(auth()->id());
        let channel = 'chat.'+userId;  
        
        console.log('mi channel establecido: '+channel); 

        if (typeof channel === 'string' && channel.trim() !== '') {

            console.log(Echo.connector);

            if (window.Echo) {            

                window.Echo.channel(channel)
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
                .on('pusher:subscription_succeeded', () => {
                    console.log('Suscrito correctamente al canal:' + channel);
                })
                .on('pusher:subscription_error', (status) => {
                    console.error('Error al suscribirse al canal '+ channel +':', status);
                })
                .error((error) => {
                    console.log('channel: '+channel);
                    console.error('Error en el canal:', error);
                });

            } else {
                console.error('window.Echo no está definido');
            }
        } 

    });
    
    Livewire.on('suscribeChannel', (receiverId) => {

        let userId = @json(auth()->id());
        let channel = 'chat.'+receiverId;  
        
        console.log('channel actualizado: '+channel); 

        if (typeof channel === 'string' && channel.trim() !== '') {

            console.log(Echo.connector);

            if (window.Echo) {            

                window.Echo.channel(channel)
                .on('pusher:subscription_succeeded', () => {
                    console.log('Suscrito correctamente al canal:' + channel);
                })
                .on('pusher:subscription_error', (status) => {
                    console.error('Error al suscribirse al canal '+ channel +':', status);
                })
                .error((error) => {
                    console.log('channel: '+channel);
                    console.error('Error en el canal:', error);
                });

            } else {
                console.error('window.Echo no está definido');
            }
        } 

    });

    /////////////////////////////////////

    // document.addEventListener('DOMContentLoaded', () => {

    //     const receiverId = @json($receiverId);        
    //     const userId = @json($userId);     

    //     console.log('ID del sender:', userId);        
    //     console.log('ID del receiver:', receiverId);        

    //     if (Number.isInteger(userId) && Number.isInteger(receiverId)) {

    //         console.log(Echo.connector);

    //         let channel = 'chat.s:' + userId+'r:'+receiverId;

    //         if (window.Echo) {            

    //             window.Echo.channel(channel)
    //             .listen('.MessageSent', (event) => {

    //                 console.log('Evento recibido en el canal:', channel);
    //                 console.log('Datos del evento:', event);

    //                 if (event && event.message) {
    //                     Swal.fire({
    //                         title: 'Nuevo mensaje',
    //                         text: event.message,
    //                         icon: 'info'
    //                     });
    //                 } else {
    //                     console.warn('El evento no tiene datos de mensaje.');
    //                 }
    //             })
    //             .on('pusher:subscription_succeeded', () => {
    //                 console.log('Suscrito correctamente al canal:' + channel);
    //             })
    //             .on('pusher:subscription_error', (status) => {
    //                 console.error('Error al suscribirse al canal '+ channel +':', status);
    //             })
    //             .error((error) => {
    //                 console.log('channel: '+channel);
    //                 console.error('Error en el canal:', error);
    //             });

    //         } else {
    //             console.error('window.Echo no está definido');
    //         }
    //     }        

    // });

</script>

@endsection
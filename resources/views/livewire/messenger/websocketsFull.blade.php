@section('websockets')
@parent

<script>

    // document.addEventListener('DOMContentLoaded', () => {

        let userId = @json(auth()->id());        

        console.log('ID del usuario:', userId);
        

        if (userId !== null && Number.isInteger(userId)) {

            console.log(Echo.connector);

            let channel = 'chat.' + userId;

            if (window.Echo) {            
                window.Echo.private(channel)
                // window.Echo.channel(channel)
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

            if (window.Echo) { 

                console.log('window.Echo definido:', window.Echo); 

                window.Echo.private(channel)
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

    // });


</script>

@endsection
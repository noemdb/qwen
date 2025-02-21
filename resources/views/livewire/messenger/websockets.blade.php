@section('websockets')

    @parent

    <script>

        Livewire.on('sendMessageFromBackEnd', (message) => {
            console.log('Haz enviado un mensaje: ' + message);
        });

        document.addEventListener('DOMContentLoaded', () => {

            console.log("Listeners registrados en Livewire:");
            
            console.log(Livewire.hook('message.sent', (message, component) => {
                console.log("Evento enviado:", message);
                console.log("Componente:", component);
            }));

            let userId = @json(auth()->id());
            let channel = 'chat.' + userId;

            console.log('Mi canal establecido: ' + channel);

            if (typeof channel === 'string' && channel.trim() !== '') {
                if (window.Echo) {
                    console.log('Laravel Echo está inicializado correctamente');

                    window.Echo.channel(channel)
                        .listen('message.sent', (event) => {
                            
                            console.log('Evento recibido en el canal:', channel);
                            console.log('Datos del evento:', event);

                            if (event && event.message) {
                                Swal.fire({
                                    title: 'Nuevo mensaje',
                                    text: event.message.body,
                                    icon: 'info'
                                });
                            } else {
                                console.warn('El evento no tiene datos de mensaje.');
                            }
                        })
                        .on('pusher:subscription_succeeded', () => {
                            console.log('Suscrito correctamente al canal: ' + channel);
                        })
                        .on('pusher:subscription_error', (status) => {
                            console.error('Error al suscribirse al canal ' + channel + ':', status);
                        });
                } else {
                    console.error('window.Echo no está definido');
                }
            } else {
                console.error('El canal no es válido');
            }
        });

    </script>

@endsection
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

        if (!userId) {
            console.error('No se encontró el ID del usuario.');
            return;
        }

        if (window.Echo) {
            console.log('Laravel Echo está disponible.');

            // window.Echo.private('private-chat.' + userId)
            window.Echo.private(`chat.${userId}`)
                .listen('MessageSent', (event) => {
                    console.log('Nuevo mensaje recibido:', event);

                    if (event && event.message) {
                        Swal.fire({
                            title: 'Nuevo mensaje',
                            text: event.message,
                            icon: 'info'
                        });
                    } else {
                        console.warn('El evento no tiene datos de mensaje.');
                    }
                });

        } else {
            console.error('window.Echo no está definido');
        }
    });



</script>

@endsection
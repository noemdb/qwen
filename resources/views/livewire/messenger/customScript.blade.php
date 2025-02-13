@section('customScript')
@parent

<script>
    document.addEventListener('livewire:load', function () {
        const chatBox = document.getElementById('message-box');
        function scrollToBottom() {
            requestAnimationFrame(() => {
                const messageBox = document.getElementById('message-box');
                messageBox.scrollTo({ top: messageBox.scrollHeight, behavior: 'smooth' });
            });
        }
        window.addEventListener('message-box', scrollToBottom);
        scrollToBottom();
        Livewire.hook('message.processed', () => {
            scrollToBottom();
        });
    });                
</script>

<script>
    window.addEventListener('new-message-received', () => {
        Swal.fire({
            title: '¡Nuevo mensaje!',
            text: 'Has recibido un nuevo mensaje.',
            icon: "success"
        });
    });
</script>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', () => {
            const messageInput = document.getElementById('message-input');
            messageInput.focus();
        });
    });
</script>

    <script>
        // window.Echo.join(`chat.${selectedRecipient}`)
        //     .listen('MessageSent', (e) => {
        //         this.messages.push(e.message);
        // });

        // window.Echo.connector.pusher.connection.bind('connected', () => {
        //     const socketId = window.Echo.socketId();
        //     console.log('Socket ID:', socketId);

        //     // Envía el socket_id al backend (por ejemplo, mediante una solicitud AJAX o Livewire)
        // });

        // Echo.channel('chat')
        // .listen('MessageSent', (e) => {
        //     Livewire.emit('messageSent', { user: e.user, message: e.message });
        // });

    </script>

@endsection
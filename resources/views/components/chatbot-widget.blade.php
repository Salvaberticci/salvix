<!-- Chatbot Widget Integration directly in public layout or as a separate component -->
<div x-data="chatbotWidget()" x-init="initChat()" style="position:fixed; bottom:20px; right:20px; z-index:9999; font-family:var(--font-body);">
    
    <!-- Widget Button -->
    <button @click="isOpen = !isOpen" style="width:60px; height:60px; border-radius:50%; background:var(--color-red); color:white; border:none; box-shadow:0 10px 20px rgba(0,0,0,0.2); cursor:pointer; display:flex; justify-content:center; align-items:center;">
        <i x-show="!isOpen" class="ph ph-chat-circle-dots" style="font-size:2rem;"></i>
        <i x-show="isOpen" class="ph ph-x" style="font-size:2rem;"></i>
    </button>

    <!-- Widget Window -->
    <div x-show="isOpen" x-transition style="position:absolute; bottom:80px; right:0; width:350px; height:500px; background:white; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,0.15); display:flex; flex-direction:column; overflow:hidden; border:1px solid var(--color-border);">
        
        <!-- Header -->
        <div style="background:var(--color-black); color:white; padding:15px; display:flex; align-items:center; gap:15px;">
            <div style="width:40px; height:40px; border-radius:50%; background:var(--color-surface); display:flex; justify-content:center; align-items:center;">
                <i class="ph ph-robot" style="font-size:1.5rem; color:white;"></i>
            </div>
            <div>
                <strong style="display:block;">Salvix Asistente</strong>
                <span class="label-editorial" style="color:#aaa; font-size:0.8rem;">En línea</span>
            </div>
        </div>

        <!-- Chat Area -->
        <div id="chat-messages-area" style="flex-grow:1; overflow-y:auto; padding:15px; background:#fafafa; display:flex; flex-direction:column; gap:15px;">
            
            <template x-for="(msg, index) in messages" :key="index">
                <div :style="msg.role === 'user' ? 'text-align:right;' : 'text-align:left;'">
                    <span :style="msg.role === 'user' ? 'background:var(--color-gold); color:white; padding:10px 15px; border-radius:15px 15px 0 15px; display:inline-block; max-width:85%; font-size:0.9rem; text-align:left;' : 'background:white; color:black; padding:10px 15px; border-radius:15px 15px 15px 0; display:inline-block; max-width:85%; font-size:0.9rem; border:1px solid #ddd;'">
                        <span x-html="formatText(msg.content)"></span>
                    </span>
                 </div>
            </template>
            
            <div x-show="isLoading" style="text-align:left;">
                <span style="background:white; color:black; padding:10px 15px; border-radius:15px 15px 15px 0; display:inline-block; font-size:0.9rem; border:1px solid #ddd;">
                    escribiendo...
                </span>
            </div>
        </div>

        <!-- Input Area -->
        <form @submit.prevent="sendMessage" style="padding:15px; background:white; border-top:1px solid #eee; display:flex; gap:10px; align-items:center;">
            <input type="text" x-model="newMessage" placeholder="Pregunta por nuestro menú..." style="flex-grow:1; border:none; background:#f4f4f4; padding:10px 15px; border-radius:20px; outline:none; font-family:var(--font-body); margin:0;" :disabled="isLoading">
            <button type="submit" style="background:var(--color-black); color:white; border:none; width:40px; height:40px; border-radius:50%; display:flex; justify-content:center; align-items:center; cursor:pointer;" :disabled="isLoading || newMessage.trim() === ''">
                <i class="ph ph-paper-plane-right" style="font-size:1.2rem;"></i>
            </button>
        </form>
    </div>
</div>

<script>
function chatbotWidget() {
    return {
        isOpen: false,
        isLoading: false,
        newMessage: '',
        sessionId: '',
        messages: [
            { role: 'assistant', content: '¡Hola! Soy el asistente virtual de Salvix. ¿En qué puedo ayudarte hoy o qué te gustaría ordenar?' }
        ],
        
        initChat() {
            // Generar o recuperar sessionId
            let stored = localStorage.getItem('salvix_chat_session');
            if(!stored) {
                stored = 'sess_' + Math.random().toString(36).substr(2, 9) + Date.now();
                localStorage.setItem('salvix_chat_session', stored);
            }
            this.sessionId = stored;
        },

        formatText(text) {
            return text.replace(/\n/g, '<br>');
        },

        scrollToBottom() {
            setTimeout(() => {
                const area = document.getElementById('chat-messages-area');
                if(area) area.scrollTop = area.scrollHeight;
            }, 100);
        },

        sendMessage() {
            if(this.newMessage.trim() === '') return;
            
            const txt = this.newMessage;
            this.messages.push({ role: 'user', content: txt });
            this.newMessage = '';
            this.isLoading = true;
            this.scrollToBottom();

            fetch('{{ url("/api/chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    message: txt
                })
            })
            .then(res => res.json())
            .then(data => {
                this.isLoading = false;
                if(data.success) {
                    this.messages.push({ role: 'assistant', content: data.reply });
                } else {
                    this.messages.push({ role: 'assistant', content: 'Ocurrió un error. ' + (data.reply || '') });
                }
                this.scrollToBottom();
            })
            .catch(err => {
                this.isLoading = false;
                this.messages.push({ role: 'assistant', content: 'Lo siento, no pude conectar con el servidor.' });
                this.scrollToBottom();
            });
        }
    }
}
</script>

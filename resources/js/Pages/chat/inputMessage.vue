<template>
    <div class="relative">
            <div v-show="typing" class="help-block" style="font-style: italic;">
                {{ user}} sta scrivendo...
            </div>
        <div class="grid grid-cols-6 input-box" >

            <input 
            type="text"
            v-model="message"
            @keyup.enter= "sendMessage()"
            @keydown="isTyping"
            placeholder="Scrivi qui.."
            class="col-span-5 outline-none      "
            />
            <button 
            @click="sendMessage()"
            :class="message != '' ? 'active' : '' "
            >
              Invia
            </button>

        </div>
       
    </div>
</template>

<script>
export default {
    props : ['room', 'user_name'],

    data() {
        return {
            message : '',
            user: this.user_name,
            typing: false
        }
    },
    methods : {
        sendMessage() {
            if(this.message == ' ') {
                return;
            }

            axios.post('/chat/room/' +  this.room.id + '/message', {
                message: this.message
            })
                .then( response => {
                    if(response.status == 201) {
                        this.message = '';
                        this.$emit('messageSent')
                    }
                })
                .catch( error => {
                    console.log(error);
                })         

        },
        isTyping() {
            let channel = Echo.private('pippo');
            let userName = this.user_name;
            
            function setTimeout(userName) {
                channel.whisper('typing', {
                
                user: userName,
                typing: true
                });
                
            };

            setTimeout(userName, 300);
        },
    },
    created() {
            
            let _this = this;

        Echo.private('pippo')
            .listenForWhisper('typing', (e) => {
            this.user = e.user;
            this.typing = e.typing;
           

            // remove is typing indicator after 0.9s
            setTimeout(function() {
                _this.typing = false
            }, 1900);
        });
    }
}
</script>

<style  scoped>

    .input-box {
        background-color: rgb(224, 224, 224);
    border-top : 1px solid #e6e6e6;
    padding: 5px;
    
    
    display: flex;
    justify-content: space-between;
    align-items: center ;
    }

    input {
        border-radius: 5px;
        width: 90%;
        
    }

    input:active, input:focus {
        border-color: orangered;
        --tw-ring-color: orangered;
    }

    button {
        
        padding: 7px 15px;
        background-color:lightslategrey;
        color: white;
        border-radius: 5px;
        font-size: large;
        font-weight: bold;
    }

    button.active {
        background-color: orangered;
    }
    
    button:hover {
        
        font-size: larger;
        background-color:orangered;
        transition: 0.25s;
    }
</style>
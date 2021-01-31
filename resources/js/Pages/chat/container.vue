<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <chat-room-selection 
                    v-if="currentRoom.id"
                    :rooms = "chatRooms"
                    :currentRoom="currentRoom"
                    v-on:roomchanged="setRoom( $event )"
                
                />
            </h2>
        </template>

        <div class=" container-fluid  ">
            <div class=" chat-container">
                <div class=" overflow-hidden shadow-xl sm:rounded-lg">
                   <message-container class ="message-container"
                   :messages = "messages"
                   :user_id = "user_id" />
                   <input-message 
                   :room = "currentRoom"
                   :user_name = "user_name"
                   v-on:messageSent="getMessages()" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import MessageContainer from './messageContainer.vue'
    import InputMessage from './inputMessage.vue'
    import ChatRoomSelection from './chatRoomSelection.vue'
    

    export default {


        components: {
            AppLayout,
            MessageContainer,
            InputMessage,
            ChatRoomSelection,
            
        },


        data() {
            return {
                chatRooms : [],
                currentRoom : [],
                messages : [],
                user_id : [],
                user_name : []
            }
        },

        watch: {
            currentRoom(val, oldVal) {
                if (val.id) {
                    this.disconnect(oldVal)
                }
                this.connect();
            }
        },


        methods: {
            connect() {
                if (this.currentRoom.id) {
                    let vm = this;
                    this.getMessages();
                    window.Echo.private("chat." + this.currentRoom.id)
                    .listen('.message.new', e => {
                        vm.getMessages()
                    });
                }
            },
            disconnect( room ) {
                window.Echo.leave("chat." + this.currentRoom.id)
            },
            getRooms() {
                axios.get('/chat/rooms')
                .then( response => {
                    this.chatRooms = response.data;
                    this.setRoom(response.data[0]);
                })
                .catch( error => {
                    console.log(error);
                })              
            },

            setRoom(room) {
                this.currentRoom = room;
                this.getMessages();
                
            },

            getMessages() {
                axios.get('/chat/room/' +  this.currentRoom.id + '/messages')
                .then( response => {
                    this.user_id = response.data[1];  
                    this.user_name = response.data[2];
                     
                    this.messages = response.data[0];  
                          
                })
                .catch( error => {
                    console.log(error);
                })              
            }, 
        },


        created() {
            this.getRooms();
 
        }
    }
</script>

<style scoped>
  .message-container {
      background-color: azure;
      padding-top: 10px;
       height: 70vh;
      background-image: url('https://cdna.artstation.com/p/assets/images/images/011/168/054/large/joel-morales-escobar-trama-j02.jpg?1528192578');
      
  }

  .chat-container {
      box-shadow: grey 2px 2px 5px;
      border-radius: 5px;
  }
 
  

</style>
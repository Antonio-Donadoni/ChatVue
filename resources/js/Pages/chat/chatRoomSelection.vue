<template>
    <div class="grid grid-cols-2">
        <div class="font-bold text-xl title">
            {{selected.name}} Chat
        </div>
        <div >
            <select v-model = "selected"
                    @change = "[display(), $emit('roomchanged', selected)]"
                    class="float-right">
                    <option v-for="(room, index) in rooms" :key="index" :value='room'>
                        {{room.name}}
                    </option>

            </select>
        </div>
       
    </div>
</template>

<script>
export default {
    props: ['currentRoom', 'rooms'],
    data() {
        return {
            selected : {},

        }
    },
    created() {
        this.selected = this.currentRoom;
        
    }, 
    methods : {
        display() {
            
            console.log(this.selected.id);
        }
    }
}
</script>

<style  scoped>
.title {
    color: orangered;
    font-weight: bold;
    font-size: 35px;
    display: flex;
    align-items: center ;
    text-shadow: 1px 2px rgba(255, 68, 0, 0.582);
}
select {
    background-color: orangered;
    color: white;
    font-weight: bold;
    border-radius: 5px;
   
    border: 2px outset rgb(230, 75, 19)
}


</style>
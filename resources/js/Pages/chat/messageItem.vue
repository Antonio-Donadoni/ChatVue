<template>
    <div :class="[(message.user_id == user_id)  ? 'userMessages' : 'othersMessages' ]" >
        <strong>{{message.user.name}}</strong> <br> {{message.message}} <span>{{ message.hour }}</span>
    </div>
</template>

<script>
export default {
    props : ["message", "user_id"],

}
</script>

<style scoped>
div {
    border: indigo 1px solid;
    padding: 7px 7px 15px 7px;
    border-radius: 5px;
    margin-bottom: 10px;
    min-width: 200px;
    position: relative;
}

.userMessages {
    border: rgb(137, 127, 206) 1px solid;
    background-color: rgb(185, 185, 255);
    float: right;
    margin-right: 5px;
    
    
}
.othersMessages {
    border:  rgb(137, 127, 206) 1px solid;
    background-color:rgb(234, 234, 255);
    float: left;
    margin-left: 5px;
}

span {
    position: absolute;
    bottom: 0;
    right: 5%;
    font-size: 13px;
}

</style>
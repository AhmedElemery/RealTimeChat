<template>
    <div>
        <li class="list-group-item" :class="{
            'list-group-item-success left-user' : className === 'list-group-item-success',
            'list-group-item-warning right-user' : className === 'list-group-item-warning'
        }">
            <slot></slot>
            <span id="time">{{ time }}</span>
        </li>
        <span class="badge" :class="{
            'badge-success left': badgeClass ==='badge-success',
            'badge-warning right': badgeClass ==='badge-warning'
            }">{{ user }}</span>
         
    </div>
</template>

<script>
    export default {
        props: ['color' , 'user' , 'time'],
        computed: {
            className() {
                return 'list-group-item-' + this.color;
            },
            badgeClass(){
                return 'badge-'+this.color;
            }
        },
        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>
<style>
    #time{
        color: #869006;
        font-size: 12px;
        float: right;
        position: absolute;
        right: 18px;
        bottom: 2px;
    }
    li{
        border-radius: 30px !important;
        margin-bottom: 2px;
        font-family: Helvetica, Arial, sans-serif;
        overflow-wrap: break-word;
    }
    .right{
        float: left;
        position : relative;
        left : 276px;
        clear: both;
    }
    .left{
        float: left;
        position : relative;
        left : 215px;
        clear: both;
    }
    .right-user{
        float: right; 
        
    }
</style>
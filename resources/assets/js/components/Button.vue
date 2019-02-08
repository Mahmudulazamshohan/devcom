<template>
   <button class="ui button" @click="clickBtn">Hello {{c}} {{this.$parent.api_tools.card_title_input}}</button>
</template>

<script>


    export default {
        data(){
          return {
            c:0
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
          clickBtn(){
            this.c++;
          }
        }
    };
</script>


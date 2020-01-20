require('./bootstrap');

window.Vue = require('vue');
import Vue from "vue";
import VueChatScroll from "vue-chat-scroll";
Vue.use(VueChatScroll);

import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

Vue.component('message-component', require('./components/Message.vue').default);


const app = new Vue({
    el: "#app",
    data: {
        message: "",
        chat: {
            message: [],
            user: [],
            color: [],
            time: []
        },
        typing: '',
        numberOfUser: 0
    },
    watch: {
        message() {
            Echo.private('chat')
                .whisper('typing', {
                    name: this.message
                });
        }
    },

    methods: {
        send() {
            if (this.message.length != 0) {
                this.chat.message.push(this.message);
                this.chat.user.push("You");
                this.chat.time.push(this.getTime());
                this.chat.color.push("success");

                axios
                    .post("/send", {
                        message: this.message,
                        chat: this.chat

                    })
                    .then(response => {
                        this.message = "";
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getTime() {
            let time = new Date();
            return time.getHours() + ':' + time.getMinutes();
        },
        getOldMessage() {
            axios.post("/getOldMessage")
                .then(response => {
                    if (response.data != '') {
                        //console.log(response.data);
                        this.chat = response.data;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }

    },
    mounted() {
        this.getOldMessage();

        Echo.private("chat").listen("ChatEvent", e => {
                this.chat.message.push(e.message);
                this.chat.user.push(e.user);
                this.chat.time.push(this.getTime());
                this.chat.color.push("warning");
                axios
                    .post("/saveMessage", {
                        chat: this.chat
                    })
                    .then(response => {

                    })
                    .catch(error => {
                        console.log(error);
                    });
            })
            .listenForWhisper('typing', (e) => {
                if (e.name != '') {
                    this.typing = 'typing ...... ';
                } else {
                    this.typing = '';
                }
            })

        Echo.join("chat")
            .here((users) => {
                this.numberOfUser = users.length;
            })
            .joining((user) => {
                this.numberOfUser += 1;
                this.$toaster.success(user.name + " joined here");
            })
            .leaving((user) => {
                this.numberOfUser -= 1;
                this.$toaster.warning(user.name + " left from here");
            });
    }
});
<template>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="border-bottom padding-sm">
                        <div class="user-panel">
                            <div class="pull-left image">
                                <a href="#">
                                    <img :src="user.image" alt="#" class="img-circle">
                                </a>
                            </div>
                            <div class="pull-left info">
                                <p>
                                    <a href="#" style="color: black;" v-text="user.name"></a>
                                </p>
                                <a href="#">
                                    <i class="fa fa-circle text-success"></i> En linea.
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- =============================================================== -->
                    <!-- member list -->
                    <ul class="friend-list">
                        <li class="bounceInDown" v-for="chat in chats" :class="{ 'active': ($route.params.id == chat.id) }" @click="get(chat.id)">
                            <router-link :to="{ name: 'chat.index', params: { id: chat.id } }" class="clearfix">
                                <img :src="chat.logo" alt="" class="img-circle">
                                <div class="friend-name">   
                                    <strong v-text="chat.usuario_id">John Doe</strong>
                                </div>
                                <div class="last-message text-muted" v-text="chat.last_msg">Hello, Are you there?</div>
                                <small class="time text-muted" v-text="chat.date">Just now</small>
                                <small class="chat-alert label label-danger" v-show="chat.msg_no_view >= 1" v-text="chat.msg_no_view">1</small>
                            </router-link>
                        </li>
                    </ul>
                </div>
                <!--=========================================================-->
                <!-- selected chat -->
                <div class="col-md-8 bg-white">
                    <div class="chat-message">
                        <ul id="chat" class="chat">
                            <li class="clearfix" :class="(msg.id == user.id) ? 'right' : 'left'" v-for="msg in msgs">
                                <span class="chat-img" :class="(msg.id == user.id) ? 'pull-right' : 'pull-left'">
                                    <img :src="msg.logo" :alt="msg.name">
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font" v-text="msg.name"></strong>
                                        <small class="pull-right text-muted">
                                            <i class="fa fa-clock-o"></i> <span v-text="m(msg.date).fromNow()"></span>
                                        </small>
                                    </div>
                                    <p v-text="msg.mensaje"></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="chat-box bg-white">
                        <div class="input-group" v-if="msgs">
                            <input class="form-control border no-shadow no-rounded" placeholder="Ingrese Su Mensaje Aquí..." v-model="msg" @keyup.enter="push">
                            <span class="input-group-btn">
                                <button class="btn btn-success no-rounded" type="button" @click="push"><i class="fa fa-send"></i> Enviar</button>
                            </span>
                        </div>
                    </div>            
                </div>        
            </div>
        </div>
    </div>
</template>

<style scoped="">
    /*.bg-white {background-color: #fff;}*/
    .friend-list {
        max-height: 500px;
        overflow-y: scroll;
        list-style: none;
        margin-left: -40px;
    }
    .friend-list li {border-bottom: 1px solid #eee;}
    .friend-list li a img {
        float: left;
        width: 45px;
        height: 45px;
        margin-right: 0px;
    }
    .friend-list li a {
        position: relative;
        display: block;
        padding: 10px;
        transition: all .2s ease;
        -webkit-transition: all .2s ease;
        -moz-transition: all .2s ease;
        -ms-transition: all .2s ease;
        -o-transition: all .2s ease;
    }
    .friend-list li.active a {background-color: #f1f5fc;}
    .friend-list li a .friend-name, 
    .friend-list li a .friend-name:hover {color: #777;}
    .friend-list li a .last-message {
        width: 65%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .friend-list li a .time {
        position: absolute;
        top: 10px;
        right: 8px;
    }
    small, .small {font-size: 85%;}
    .friend-list li a .chat-alert {
        position: absolute;
        right: 8px;
        top: 27px;
        font-size: 10px;
        padding: 3px 5px;
    }
    .chat-message {
        padding: 10px 0px 10px;
    }
    .chat {
        background: #eee;
        max-height: 500px;
        min-height: 500px;
        overflow-y: scroll;
        list-style: none;
        margin: 0;
    }
    .chat-message{background: #f9f9f9;}
    .chat li img {
        width: 45px;
        height: 45px;
        border-radius: 50em;
        -moz-border-radius: 50em;
        -webkit-border-radius: 50em;
    }
    img {max-width: 100%;}
    .chat-body {padding-bottom: 20px;}
    .chat li.left .chat-body {margin-left: 70px; background-color: #fff;}
    .chat li .chat-body {
        position: relative;
        font-size: 11px;
        padding: 10px;
        border: 1px solid #f1f5fc;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .chat li .chat-body .header {padding-bottom: 5px; border-bottom: 1px solid #f1f5fc;}
    .chat li .chat-body p {margin: 0;}
    .chat li.left .chat-body:before {
        position: absolute;
        top: 10px;
        left: -8px;
        display: inline-block;
        background: #fff;
        width: 16px;
        height: 16px;
        border-top: 1px solid #f1f5fc;
        border-left: 1px solid #f1f5fc;
        content: '';
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
    }
    .chat li.right .chat-body:before {
        position: absolute;
        top: 10px;
        right: -8px;
        display: inline-block;
        background: #fff;
        width: 16px;
        height: 16px;
        border-top: 1px solid #f1f5fc;
        border-right: 1px solid #f1f5fc;
        content: '';
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
    }
    .chat li {margin: 15px 0;}
    .chat li.right .chat-body {margin-right: 70px; background-color: #fff;}
    .chat-box {
        /*position: fixed;*/
        /*bottom: 0;*/
        /*left: 444px;*/
        /*right: 0;*/
        /*padding: 15px;*/
        /*border-top: 1px solid #eee;*/
        /*transition: all .5s ease;*/
        /*-webkit-transition: all .5s ease;*/
        /*-moz-transition: all .5s ease;*/
        /*-ms-transition: all .5s ease;*/
        /*-o-transition: all .5s ease;*/
    }
    .primary-font {color: #3c8dbc;}
    a:hover, a:active, a:focus {text-decoration: none; outline: 0;}
</style>

<script>
    export default {
        name: 'Chat',
        data() {
            return {
                interval: {},
                last_id: 0,
                user: [],
                chats: [],
                msgs: [],
                msg: '',
                m: window.moment
            };
        },
        created() {
            this.getData();
            this.get();
        },
        methods: {
            get(id = null) {
                if (id == this.$route.params.id) return;
                if (id) {
                    this.last_id = 0;
                    this.msgs = [];
                    this.msg = '';
                }
                axios.get('/chats/' + ((id) ? id : this.$route.params.id) + '?last=' + this.last_id)
                .then(response => {
                    for(let i in response.data) {
                        if (this.last_id == response.data[i].id) continue;
                        this.msgs.push({
                            id: response.data[i].usuario_id,
                            name: response.data[i].usuario,
                            mensaje: response.data[i].mensaje,
                            logo: response.data[i].logo,
                            date: response.data[i].date,
                        });
                        this.last_id = response.data[i].id;
                    }
                    if (response.data.length != 0) {
                        setTimeout(() => {document.getElementById('chat').scrollTop = 999999999999999}, 500);
                    }
                    clearTimeout(this.interval);
                    this.interval = setTimeout(() => {this.get();}, 2500);
                });
            },
            getData() {
                axios.post('/get-data-chats')
                .then(response => {
                    this.user = response.data.user
                    this.chats = response.data.chats
                });
            },
            push() {
                if (this.msg == '') return;
                if (!this.$route.params.id) return;
                axios.post('/chats', {
                    msg: this.msg,
                    chat: this.$route.params.id
                })
                .then(response => {
                    this.msg = '';
                    this.get();
                });
            },
        }
    }
</script>

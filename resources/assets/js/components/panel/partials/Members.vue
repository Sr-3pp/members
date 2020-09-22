<template>
    <section desk="members">
        <div class="tabs-component">
            <ul class="tabs">
                <li @click="section = 0" class="item" :class="{'active': section === 0}">
                    Miembros
                </li>
                <li @click="section = 1" class="item" :class="{'active': section === 1}">
                    Empresas
                </li>
                <li class="item action search" :class="{'active': searchTab}">
                    <button @click="searchTab ? searchTab = false : searchTab = true">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="search-input">
                        <input @keyup="searchFor()" placeholder="Folio / Nombre" type="text" v-model="search">
                    </div>
                </li>
                <li @click="$bus.$emit('registerModal', {sw: section, admin: 1})" class="item action">
                    <i class="fas fa-plus"></i>
                </li>
            </ul>
            <div class="contents">
                <ul class="content">
                    <ol v-for="(u, i) in list" :key="u.id" class="item">
                    <span @click="toggleStatus(u.id, i)" class="status" :class="{'active': u.status}"></span>
                    <p class="folio">
                        {{u.user.folio}}
                    </p>
                    <p class="text">
                        {{u.name}} {{u.appelido_m}} {{u.appelido_p}}
                    </p>
                    <div class="actions">
                        <button @click="userDetail(u)" class="btn btn-primary">
                            Detail
                        </button>
                        <button class="btn btn-danger">
                            Delete
                        </button>
                    </div>
                </ol>
                </ul>
            </div>
        </div>
        <article class="user-detail" :class="{'active': duser}">
            <ul class="content">
                <div class="actions">
                    <button @click="edit ? edit = false : edit = true">
                        edit
                    </button>
                </div>
                <template v-for="(u, i) in duser">
                    <figure v-if="i == 'foto'" class="img" :key="i+1">
                        <img :src="'/storage/'+ u" alt="">
                    </figure>

                    <li v-if="!i.includes('_id') && !['status', 'foto', 'website', 'fb', 'tw', 'in', 'created_at', 'updated_at', 'pais', 'user', 'id', 'programas'].includes(i)" :key="i+1" class="item">
                        <template v-if="!edit">
                            <p class="title">
                                {{i}} :
                            </p>
                            <p v-if="u != null" class="text">
                                {{i != 'idiomas' ? u : JSON.parse(u)}}
                            </p>
                            <p v-else>
                                --------------
                            </p>
                        </template>
                        <template v-else>
                            <div class="input">
                                <label class="label">
                                    {{i}}
                                </label>
                                <input type="text" v-model="duser[i]">
                            </div>
                        </template>
                    </li>
                    <template v-if="i == 'user'">
                        <template v-for="(du, ind) in u">
                            <li class="item" :key="ind+1">
                                <p class="title">
                                    {{ind}} :
                                </p>
                                <p class="text">
                                    {{du}}
                                </p>
                            </li>
                        </template>
                    </template>
                </template>
            </ul>
            <div @click="duser = false" class="overlay"></div>
        </article>
    </section>
</template>

<script>
export default {
    data () {         
        return {
            duser: false,
            users: [],
            empresas: [],
            list: [],
            section: 0,
            search: null,
            searchTab: false,
            edit: false
        }
    },
    mounted () {
        var este = this;
        axios.get('/panel/get-users').then((r)  => {
            este.users = r.data
            este.list = este.users
        }) 
        
        axios.get('/panel/get-empresas').then((r)  => {
            este.empresas = r.data
        })
    },
    methods: {
        toggleStatus(id, key){
            var este = this;
            axios.get('/status-user/'+id).then(function(user){
                if (este.empresa) {
                    este.empresas.splice(key, 1);
                    este.empresas.splice(key, 0, user.data);
                }else {
                    este.users.splice(key, 1);
                    este.users.splice(key, 0, user.data);
                }
            });
        },
        searchFor(){
            var este = this;
            if (!this.section) {
                if (this.search.length > 3) {
                    axios.post('/search-members', {nombre: this.search, magic: '2'}).then(function(users){
                        este.list = users.data
                    });
                }else {
                    este.list = este.users
                }
            }else{
                if (this.search.length > 3) {
                    axios.post('/search-empresas', {nombre: this.search}).then(function(empresas){
                        este.list = empresas.data
                    });
                }else {
                    este.list = este.empresas
                }
            }
        },
        userDetail(u){
            console.log(u);
            this.duser = u
        }
    },
    watch: {
        section: {
            handler(val) {
                this.search = null
                this.searchTab = false 
                if (val) {
                    this.list = this.empresas
                }else{
                    this.list = this.users
                }
            }
        }
    }
}
</script>

<style lang="scss">
    .status{
        width: 1rem;
        height: 1rem;
        background-color: red;
        border-radius: 100%;
        cursor: pointer;
        &.active{
            background-color: green; 
        }
    }
    [desk="members"]{
        max-width: 1100px;
        margin: 2rem auto;
        .tabs-component{
            >ul{
                padding: 0;
                list-style: none;
            }
            .tabs{
                display: flex;
                border-bottom: {
                            style: solid;
                            color:  rgba(#383737, .3);
                            width: 1px;
                        }
                >*{
                    background-color: #383737;
                    color: #FFF;
                    padding: .5rem;
                    cursor: pointer;
                    border-top-left-radius: 10px;
                    border-top-right-radius: 10px;
                    &:not(:last-child){
                        margin-right: 1rem;
                    }
                    &.active{
                        background-color: #00a7ff;
                    }
                    &.search{
                        position: relative;
                        margin-left: auto;
                        padding: 0;
                        min-width: 2rem;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        button{
                                background-color: transparent;
                                border: none!important;
                                padding: 0;
                                height: 100%;
                                color: #FFF;
                                outline: none!important;
                        }
                        .search-input{
                            position: absolute;
                            top: 0;
                            right: 100%;
                            height: 100%;
                            width: 15rem;
                            max-width: 0;
                            overflow: hidden;
                            transition: all .35s ease;
                            input{
                                width: 100%;
                                height: 100%;
                                border: none;
                                border-left: {
                                    style: solid;
                                    color:  #00a7ff;
                                    width: .2rem
                                }
                            }
                        }
                        &.active{
                            border-top-left-radius: 0;
                            .search-input{
                                max-width: 100vw;
                            }
                        }
                    }
                }
            }
            .contents{
                .content{
                    display: flex;
                    align-items: center;
                    padding: 0;
                    flex-direction: column;
                    .item{
                        display: flex;
                        align-items: center;
                        padding: 0;
                        width: 100%;
                        >*{
                            margin-bottom: 0;
                            &:not(:last-child){
                                margin-right: 1rem;
                            }
                            &:last-child{
                                margin-left: auto;
                            }
                            &.actions{
                                width: auto;
                            }
                        }
                        &:not(:last-child){
                            border-bottom: {
                                style: solid;
                                color:  rgba(#383737, .3);
                                width: 1px;
                            }
                        }
                    }
                }
            }
        }
        .user-detail{
            background: rgba(#5d5d5d, .5);
            position: fixed;
            z-index: -1;
            visibility: hidden;
            opacity: 0;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .35s ease;
            &.active{
                visibility: visible;
                opacity: 1;
                z-index: 4;
            }
            .overlay{
                position: absolute;
                z-index: 3;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
            }
            .content{
                position: relative;
                z-index: 4;
                background-color: #FFF;
                height: 80vh;
                min-height: 500px;
                width: 80vw;
                min-width: 300px;
                overflow-y: auto;
                padding: 2rem;
                display: flex;
                flex-wrap: wrap;
                .actions{
                    position: absolute;
                    top: 0;
                    right: 0;
                    width:auto;
                }
                .img{
                    width: 10rem;
                    border-radius: 100%;
                    height: 10rem;
                    order: -1;
                }
                .item{
                    list-style: none;
                    padding: 1rem;
                    margin: auto;
                    .title{
                        font-weight: bold;
                        margin-bottom: 0;
                        text-transform: capitalize;
                    }
                    .text{
                        color: #3b3b3b;
                    }
                }
            }
        }
    }
</style>
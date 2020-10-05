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
                    <span @click="toggleStatus(u.user_id, i)" class="status" :class="{'active': u.status}"></span>
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
                        <button @click="deleteUser(u, i)" class="btn btn-danger">
                            Delete
                        </button>
                    </div>
                </ol>
                </ul>
            </div>
        </div>
        <article class="user-detail" :class="{'active': duser}">
            <ul class="content" v-if="duser">
                <figure class="profile">
                    <div class="actions">
                        <button class="btn btn-primary" @click="edit ? edit = false : edit = true">
                            <i class="far fa-edit"></i>
                        </button>
                    </div>
                    <label class="img" :class="{'edit': edit}">
                        <img class="user" :src="'/storage/'+ duser.foto" alt="">
                        <img v-if="!edit" class="rango" :src="'/media/img/medallas/' + duser.rango + '.png'" alt="">
                        <input v-if="edit" type="file" accept="*/image" @change="setPic($event)">
                    </label>
                    <div v-if="edit" class="rangos">
                        <label class="rango">
                            <input type="radio" name="rango" value="afiliado" v-model="duser.rango">
                            <img src="/media/img/medallas/afiliado.png" alt="">
                        </label>
                        <label class="rango">
                            <input type="radio" name="rango" value="especialista" v-model="duser.rango">
                            <img src="/media/img/medallas/especialista.png" alt="">
                        </label>
                        <label class="rango">
                            <input type="radio" name="rango" value="experto" v-model="duser.rango">
                            <img src="/media/img/medallas/experto.png" alt="">
                        </label>
                        <label class="rango">
                            <input type="radio" name="rango" value="profesional" v-model="duser.rango">
                            <img src="/media/img/medallas/profesional.png" alt="">
                        </label>
                    </div>
                </figure>

                <ul class="categorias">
                    <p class="title">
                        Categorias
                    </p>
                    <label v-for="(c, ci) in categorias" class="img" :key="ci + 1">
                        <input :disabled="!edit" type="checkbox" name="categoria" :true-value="c.id" :checked="duser.user.categorias.map((e) => {return e.categoria_id}).includes(c.id)">
                        <img :src="'/media/img/categorias/'+ c.nombre +'.png'" alt="">
                    </label>
                </ul>

                <template v-for="(du, ind) in duser.user">
                    <li v-if="!['perfil', 'tipo', 'valoracion', 'cats', 'categorias', 'id', 'created_at', 'updated_at'].includes(ind) && !edit" class="item full" :key="ind+1">
                        <p class="title">
                            {{ind}} :
                        </p>
                        <p class="text">
                            {{du}}
                        </p>
                    </li>
                    <div class="input email" v-if="edit && ind == 'email'" :key="ind+1">
                        <label class="label">
                            {{ind}}
                        </label>
                        <input type="text" v-model="duser.user.email">
                    </div>
                </template>

                <div class="input password" v-if="edit">
                    <label class="label">
                        Password
                    </label>
                    <input type="password" placeholder="set password" v-model="duser.user.password">
                </div>

                <li class="pais item">
                    <p class="title">
                        País:
                    </p>
                    <p v-if="!edit" class="text">
                        {{duser.pais.nombre}}
                    </p>
                    <div v-else class="input">
                        <select class="form-control" v-model="duser.pais_id">
                            <option :value="pais.id" v-for="pais in paises" :key="pais.id">{{pais.nombre}}</option>
                        </select>
                    </div>
                </li>

                <template v-for="(u, i) in duser">
                    <li v-if="!i.includes('_id') && !['status', 'foto', 'website', 'fb', 'tw', 'in', 'created_at', 'updated_at', 'pais', 'user', 'cats', 'id', 'programas', 'idiomas', 'rango'].includes(i)" :key="i+1" class="item">
                        <template v-if="!edit">
                            <p class="title">
                                {{i}} :
                            </p>
                            <p v-if="u != null" class="text">
                                {{u}}
                            </p>
                            <p v-else>
                                --------------
                            </p>
                        </template>
                        <template v-else>
                            <div class="input" v-if="!['resumen', 'educacion'].includes(i)">
                                <label class="label">
                                    {{i}}
                                </label>
                                <input type="text" v-model="duser[i]">
                            </div>
                            <div v-else class="input">
                                <label class="label">
                                    {{i}}
                                </label>
                                <textarea type="text" v-model="duser[i]"></textarea>
                            </div>
                        </template>
                    </li>
                    
                    <ul class="idiomas item" v-if="i == 'idiomas'" :key="i+1">
                        <p class="title">
                            {{i}}
                        </p>
                        <li class="item" v-for="(idioma, iid) in u" :key="iid+1">
                            <p class="text">{{idioma}}</p>
                            <button v-if="edit" @click="duser.idiomas.splice(iid, 1)" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                        </li>
                        <li v-if="edit" class="item list">
                            <div class="input-group">
                                <input @keyup="searchIdioma" type="text" class="form-control" placeholder="Agregar idioma" v-model="idioma">
                            </div>
                            <transition name="fade">
                                <ul v-if="idiomasResults && idioma !== ''" class="list-group input-results">
                                    <button @click="duser.idiomas.push(idioma.nombre)" :key="idioma.id" role="button" class="list-group-item list-group-item-action" v-for="idioma in idiomasResults">{{idioma.nombre}}</button>
                                </ul>
                            </transition>
                        </li>
                    </ul>
                </template>

                <ul class="valoraciones">
                        <p class="title">
                            Valoraciones
                        </p>
                        <li class="item" :class="{'edit': edit}" v-for="(v, ind) in duser.user.valoracion" :key="ind+1">
                            <button @click="duser.user.valoracion.splice(ind, 1)" v-if="edit">
                                <i class="fas fa-times danger"></i>
                            </button>
                            <p class="text">
                                {{v.area}}
                            </p>
                            <span class="star" @click="edit ? v.porcentaje = n : null" :class="{'active': n <= parseInt(v.porcentaje)}" v-for="n in 10" :key="n">
                                <i class="fas fa-star"></i>
                            </span>
                        </li>
                        <li class="item new" v-if="edit && nval.status">
                            <div class="input">
                                <label class="label">
                                    Area
                                </label>
                                <input type="text" v-model="nval.area">
                            </div>
                            <div class="input stars">
                                <label class="label">
                                    Porcentaje
                                </label>
                                <span class="star" @click="nval.porcentaje = n" :class="{'active': n <= parseInt(nval.porcentaje)}" v-for="n in 10" :key="n">
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            <button class="btn btn-secondary" @click="duser.user.valoracion.push(nval)">
                                agregar
                            </button>
                        </li>
                        <li v-if="edit && duser.user.valoracion.length < 5" class="item">
                            <button class="btn btn-primary" @click="nval.status ? nval.status = false : nval.status = true">
                                <i class="fas fa-plus"></i>
                            </button>
                        </li>
                    </ul>

                <button @click="updateUser()" v-if="edit" class="btn btn-primary">
                    Guardar
                </button>
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
            edit: false,
            idiomas: false,
            npicture: false,
            categorias: false,
            paises: false,
            idioma: null,
            idiomasResults: false,
            nval: {
                status: false,
                area: null,
                porcentaje: 1
            }

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

        axios.get('/get-idiomas').then(function(idiomas){
            este.idiomas = idiomas.data
        });
        
        axios.get('/get-categorias').then(function(categorias){
            este.categorias = categorias.data
        });

        axios.get('/get-paises').then(function(paises){
            este.paises = paises.data
        });
    },
    methods: {
        toggleStatus(id, key){
            var este = this;
            axios.get('/status-user/'+id).then(function(user){
                este.list.splice(key, 1);
                este.list.splice(key, 0, user.data);
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
        searchIdioma(){
            var este = this;
            axios.post('/search-idioma', {idioma: this.idioma}).then(function(idiomas){
                este.idiomasResults = idiomas.data.data
            });
        },
        userDetail(u){
            let idiomas;
            try {
                idiomas = JSON.parse(u.idiomas)
            } catch (error) {
                idiomas = u.idiomas
            }
            try {
                u.idiomas = idiomas.split(',')
            } catch (error) {
                u.idiomas = idiomas
            }

            this.duser = u
            this.duser.user.cats = this.duser.user.categorias.map((e) => {if (e && e.categoria != null) {return e.categoria_id}})
        },
        updateUser () {
            const data = {};
            const formData = new FormData;
            Object.keys(this.duser).map((k) => {
                if (!['user', 'cats', 'pais', 'created_at', 'updated_at', 'status', 'programas', 'user_id', 'id', 'foto', 'idiomas'].includes(k)) {
                    const el = this.duser[k]
                    data[k] = el
                }
            })
            data['user_id'] = this.duser.user_id
            data['email'] = this.duser.user.email
            data['categorias'] = JSON.stringify(this.duser.user.cats)
            data['valoraciones'] = JSON.stringify(this.duser.user.valoracion)
            data['idiomas'] = this.duser.idiomas.join()

            if (this.npicture) {
                data['foto'] = this.npicture
            }

            Object.keys(data).map((k) => {
                const e = data[k];
                formData.append(k, e)
            })

            axios.post('/panel/update-user', formData).then(response => {
                const u = response.data
                let idiomas;
                try {
                    idiomas = JSON.parse(u.idiomas)
                } catch (error) {
                    idiomas = u.idiomas
                }
                try {
                    u.idiomas = idiomas.split(',')
                } catch (error) {
                    u.idiomas = idiomas
                }
                this.duser = u
                this.duser.user.cats = this.duser.user.categorias.map((e) => {return e.categoria.id})
                this.duser.user.valoracion = JSON.parse(data['valoraciones']);
                this.edit = false
            })
        },
        setPic($event){
            this.npicture = $event.target.files[0]
            $('.profile .user').attr('src', URL.createObjectURL(this.npicture))
        },
        deleteUser (u, i) {
            if (confirm('Eliminar usuario' + u.folio + '?')) {
                var este = this;
                axios.get('delete-user/' + u.id).then(function(response) {
                    if (response.data == '1') {
                        this.list.splice(i, 1);
                    }
                });
            }
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
    .input{
        display: flex;
        flex-direction: column;
        .label{
            font-weight: bold;
        }
        textarea{
            min-height: 7rem;
            min-width: 10rem;
        }
        &.email, &.password{
            width: auto;
        }
        &.email{
            margin-right: 1rem;
        }
    }
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
                align-items: center;
                flex-wrap: wrap;
                ul{
                    padding: 0;
                    list-style: none;
                    .title{
                        font-weight: bold;
                        margin-bottom: 0;
                    }
                    &.idiomas{
                        display: flex;
                        flex-wrap: wrap;
                        flex-grow: 1;
                        max-width: 50%;
                        .title{
                            flex-basis: 100%;
                        }
                        .item{
                            padding: .3rem;
                            background-color: #00a7ff;
                            color: #FFF;
                            border-radius: .2rem;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            &:not(:last-child){
                                margin-right: 1rem;
                            }
                            .text{
                                margin-bottom: 0;
                                color: #FFF;
                            }
                            &.list{
                                background-color: transparent;
                                padding: 0;
                                flex-basis: 100%;
                                margin-top: 1rem;
                                position: relative;
                                .input-results{
                                    position: absolute;
                                    top: 100%;
                                    left: 0;
                                    width: 100%;
                                    overflow: hidden;
                                }
                            }
                        }
                    }
                }
                >.img{
                    overflow: hidden;
                    img{
                        width: 100%;
                        height: auto;
                    }
                }
                .profile{
                    flex-basis: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: relative;
                    flex-wrap: wrap;
                    margin-bottom: 4rem;
                    .actions{
                        position: absolute;
                        top: 0;
                        right: 0;
                        width:auto;
                    }
                    .img{
                        position: relative;
                        input{
                            display: none;
                        }
                        &.edit{
                            cursor: pointer;
                        }
                        .user{
                            width: 10rem;
                            border-radius: 100%;
                            height: 10rem;
                            border-radius: 100%;
                            overflow: hidden;
                            object-fit: cover;
                            box-shadow: 0rem .2rem 1rem rgba(#424242, .2);
                            border: {
                                style: solid;
                                color: #FFF;
                                width: .5rem;
                            }
                        }
                        .rango{
                            position: absolute;
                            bottom: 0;
                            left: 50%;
                            transform: translate(-50%, 50%);
                            width: 5rem;
                            height: 5rem;
                        }
                    }
                    .rangos{
                        display: flex;
                        flex-basis: 100%;
                        align-items: center;
                        justify-content: center;
                        .rango{
                            cursor: pointer;
                            input{
                                display: none;
                                &:checked{
                                    ~img{
                                        width: 3.5rem;
                                        border-radius: 100%;
                                        box-shadow: 0 .2rem .2rem rgba(#383737, .3);
                                    }
                                }
                            }
                            img{
                                width: 3rem;
                            }
                        }
                    }
                }
                .item{
                    list-style: none;
                    padding: 1rem;
                    margin: 0;
                    .title{
                        font-weight: bold;
                        margin-bottom: 0;
                        text-transform: capitalize;
                    }
                    .text{
                        color: #3b3b3b;
                    }
                }

                .categorias{
                    flex-basis: 100%;
                    display: flex;
                    flex-wrap: wrap;
                    margin-bottom: 2rem;
                    .title{
                        flex-basis: 100%;
                    }
                    .img{
                        background-color: transparent;
                        border: none;
                        border-radius: 100%;
                        padding: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        img{
                            opacity: .3;
                            width: 3rem;
                            border-radius: 100%;
                        }
                        &:not(:last-child){
                            margin-right: 1rem;
                        }
                        input{
                            display: none;
                            &:checked{
                                ~img{
                                    opacity: 1;
                                    box-shadow: 0 .2rem .2rem rgba(#383737, .3);
                                }
                            }
                        }
                    }
                }

                .valoraciones{
                    display: flex;
                    flex-wrap: wrap;
                    .title{
                        flex-basis: 100%;
                    }
                    .item{
                        padding: 1rem;
                        .text{
                            margin-bottom: 0;
                        }
                        .star{
                            color: #bbbbbb;
                            &.active{
                                color:  #00a7ff;
                            }
                        }
                        &.edit{
                            button{
                                background-color: transparent;
                                border: none;
                                padding: 0;
                            }
                            .star{
                                cursor: pointer;
                            }
                        }
                        &.new{
                            .stars{
                                display: flex;
                                flex-wrap: wrap;
                                flex-direction: row;
                                .label{
                                    flex-basis: 100%;
                                }
                                input{
                                    margin-bottom: 1rem;
                                    .star{
                                        cursor: pointer;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
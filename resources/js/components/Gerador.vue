<template>
    <div id="vue-instance">
        <select id="prova_id" class="form-control" @change="onChange($event)" name="prova_id" required autocomplete="prova_id" v-model="selected">
    <option disabled selected value> -- Selecione uma opção -- </option>
    <option v-for="prova in provas" :value="prova" :key="prova.id">
        {{prova.nome}}
        </option>
    </select>
    <p>
        <div v-for="participante in selected.participante_prova"> 
            "Teste"
        </div>
    </p>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                result: {}
            }
        },
        props: {
            provas: {
                type: Object,
                default: null
            },
            selected: {
                type: Object,
                default: null
            }
        },
        methods: {
            onChange(event) {
                console.log(event.target.value)
            }
        }
        // data() {
        //    return {
        //         provas: {}
        //    }
        // },
        // created() {
        //     this.provas = [
        //         {nome: 'MacBook Air', id: 1},
        //         {nome: 'MacBook Pro', id: 2},
        //         {nome: 'Lenovo W530', id: 3},
        //         {nome: 'Acer Aspire One', id: 4}
        //     ]
        // },
    }    
</script>
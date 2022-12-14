<template>

    <form @submit.prevent="submit">

    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <label for="prova_id" class="col-md-4 col-form-label text-md-end">{{ 'Prova' }}</label>
        </div>
    </div>

    <div class="row mb-3">

        <div class="col-md-6 offset-md-3" >

        <select id="prova_id" class="form-control" name="prova_id" required autocomplete="prova_id" v-model="selected">
            <option disabled selected value> -- Selecione um opção -- </option>
            <option v-for="prova in provas" :value="prova" :key="prova.id">
                {{prova.nome}}
                </option>
        </select>
        <p v-if="selected">
            {{selected.participante_prova.length}} Participantes
        </p>

        </div>

        <div class="col-md-3">
            <a class="btn btn-primary" href="http://localhost/prova">
                {{ '+' }}
            </a>
        </div>

    </div>

    <div v-if="selected" class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <label for="prova_id" class="col-md-4 col-form-label text-md-end">{{ 'Salas'}}</label>
        </div>
    </div>

    <div v-if="selected" class="row mb-3">

        <div class="col-md-6 offset-md-3" >

            <select id="sala_id" class="form-control"  @change="calcCapacidade($event)" name="sala_id" required autocomplete="sala_id" v-model="sala" multiple>
                <option disabled selected value> -- Selecione a(s) sala(s) -- </option>
                <option v-for="sala in salas" :value="sala" :key="sala.id">
                    {{sala.nome}} - {{sala.setor}} ({{sala.capacidade}})
                    </option>
            </select>

            Capacidade Disponível: {{capacidade}} lugares

        </div>

        <div class="col-md-3">
            <a class="btn btn-primary" href="http://localhost/sala">
                {{ '+' }}
            </a>
        </div>
    </div>
    
    <div class="row mb-0">
        <div class="col-md-6 offset-md-5">
            <button type="submit" class="btn btn-primary" :disabled="(submitDisponivel == false)">
                {{ 'Processar' }}
            </button>
        </div>
    </div>

    </form>

</template>

<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    export default {
        props: {
            provas: {
                type: Object,
                default: null
            },
            salas: {
                type: Object,
                default: null
            }
        },
        methods: {
            calcCapacidade(event) {
                this.capacidade = 0;
                this.sala.forEach(element => this.capacidade += element.capacidade)
                this.verificarCapacidade()                                
            },
            verificarCapacidade() {
                if(this.selected) {
                    if (this.capacidade >= this.selected.participante_prova.length && this.capacidade != 0) {
                        this.submitDisponivel = true;
                    } else {
                        this.submitDisponivel = false;
                    }
                }
            },
            nomeComCapacidade({ nome, capacidade }){
                return `${nome} [${capacidade}]`
            },submit() {
                this.errors = {};
                axios.post('/gerador', {
                    prova: this.selected,
                    salas: this.sala
                }).then(response => {
                    window.location.href = "http://localhost/gerador";
                }).catch(error => {
                    alert("Erro! Tente Novamente!");
                });
                },
        },
        data() {
           return {
                capacidade: 0,
                submitDisponivel: false,
                fields: {},
                errors: {},
                selected: null,
                sala: null
           }
        },
    }    
</script>
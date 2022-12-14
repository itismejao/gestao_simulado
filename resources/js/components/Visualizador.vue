<template>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Visualizador de lugares</div>

                <div class="card-body">

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <label for="prova_id" class="col-md-4 col-form-label text-md-end">{{ 'Prova' }}</label>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6 offset-md-3">

                            <select id="prova_id" class="form-control" name="prova_id" @change="buscarSalas($event)"
                                required autocomplete="prova_id" v-model="selected">
                                <option disabled selected value> -- Selecione uma opção -- </option>
                                <option v-for="prova in provas" :value="prova" :key="prova.id">
                                    {{ prova.nome }}
                                </option>
                            </select>

                        </div>

                    </div>

                    <div v-if="salas" class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <label for="prova_id" class="col-md-4 col-form-label text-md-end">{{ 'Salas' }}</label>
                        </div>
                    </div>

                    <div v-if="salas" class="row mb-3">

                        <div class="col-md-6 offset-md-3">

                            <select id="sala_id" class="form-control" name="sala_id" required autocomplete="sala_id"
                                v-model="sala">
                                <option disabled selected value> -- Selecione uma opção -- </option>
                                <option v-for="sala in salas" :value="sala" :key="sala.id">
                                    {{ sala.nome }} - {{ sala.setor }} ({{ sala.capacidade }})
                                </option>
                            </select>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div v-if="sala" class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ sala.nome }} - {{ sala.setor }}</div>
                <div class="card-body">
                    <div class="container">
                        <div v-for="linhas in (sala.capacidade/sala.fileiras)" :key="linhas" class="row align-items-center">
                            <div v-for="colunas in sala.fileiras" :key="colunas" class="col align-middle">
                                {{participantePosicao((linhas-1)+' - '+(colunas-1))}}
                                <div>{{typeof this.part == "undefined" ? '' : this.part.participante.nome}}</div>
                                <div>{{typeof this.part == "undefined" ? 'Vazio' :   this.part.participante.turma.ano+'º'+ this.part.participante.turma.nome_turma}}</div>
                                <div>{{typeof this.part == "undefined" ? (linhas-1)+' - '+(colunas-1) : this.part.posicao}}</div>
                                <br>                                
                            </div>
                        </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
export default {
    props: {
        provas: {
            type: Object,
            default: null
        }
    },
    methods: {
        buscarSalas() {
            this.errors = {};
            axios.post('/visualizador', {
                prova: this.selected,
            }).then(response => {
                this.salas = response.data.salas;
                this.participantes = response.data.participantes;
            }).catch(error => {
                alert("Erro! Tente Novamente!");
            });
        },
        participantePosicao(posicaoFind) {
            const result = this.participantes.find(({ posicao, sala_id }) => posicao === posicaoFind && sala_id === this.sala.sala_id);
            this.part = result;
            //return typeof result == "undefined" ? posicaoFind : result.participante.turma.ano+'º'+result.participante.turma.nome_turma+' - '+ result.participante.nome ;
        }
    },
    data() {
        return {
            errors: {},
            selected: null,
            salas: null,
            sala: null,
            participantes: null,
            part: null
        }
    },
}    
</script>
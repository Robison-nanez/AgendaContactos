<template>
    <div data-app app-data="true">
        <v-container>
            <v-row>
                <v-col>
                    <v-card>
                        <v-row>
                            <v-col
                                cols="12"
                                sm="12"
                                md="6"
                                lg="6"
                                xl="6"
                            >
                                <v-card-title>Listar Agenda</v-card-title>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="12"
                                md="6"
                                lg="6"
                                xl="6"
                            >
                            <v-dialog
                                    v-model="dialog"
                                    width="500"
                                    persistent
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            style="float: right; margin-right: 5%;"
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            Nuevo Contacto
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-title class="text-h5 grey lighten-2">
                                            {{ textomodal }}
                                        </v-card-title>

                                        <v-card-text>
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    sm="12"
                                                    md="12"
                                                    lg="12"
                                                    xl="12"
                                                >
                                                    <v-text-field
                                                        v-model="data.nombre"
                                                        label="Nombre"
                                                        filled
                                                        clearable
                                                        counter="100"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    sm="12"
                                                    md="12"
                                                    lg="12"
                                                    xl="12"
                                                >
                                                    <v-text-field
                                                        v-model="data.telefono"
                                                        label="Telefono"
                                                        filled
                                                        clearable
                                                        counter="20"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    sm="12"
                                                    md="12"
                                                    lg="12"
                                                    xl="12"
                                                >
                                                    <v-menu
                                                        ref="menu"
                                                        v-model="menu"
                                                        :close-on-content-click="false"
                                                        :return-value.sync="data.fecha"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="auto"
                                                    >
                                                        <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                            v-model="data.fecha"
                                                            label="Fecha"
                                                            filled
                                                            clearable
                                                            v-bind="attrs"
                                                            v-on="on"
                                                        ></v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                            v-model="data.fecha"
                                                            no-title
                                                            scrollable
                                                        >
                                                        <v-spacer></v-spacer>
                                                        <v-btn
                                                            text
                                                            color="primary"
                                                            @click="menu = false"
                                                        >
                                                            Cancel
                                                        </v-btn>
                                                        <v-btn
                                                            text
                                                            color="primary"
                                                            @click="$refs.menu.save(data.fecha)"
                                                        >
                                                            OK
                                                        </v-btn>
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    sm="12"
                                                    md="12"
                                                    lg="12"
                                                    xl="12"
                                                >
                                                    <v-text-field
                                                        v-model="data.direccion"
                                                        label="Direccion"
                                                        filled
                                                        clearable
                                                        counter="50"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    sm="12"
                                                    md="12"
                                                    lg="12"
                                                    xl="12"
                                                >
                                                    <v-text-field
                                                        v-model="data.correo"
                                                        label="Correo"
                                                        filled
                                                        clearable
                                                        counter="100"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-card-text>

                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                @click="dialog = false"
                                                style="background:red; color:white"
                                            >
                                                Cancelar
                                            </v-btn>
                                            <v-btn
                                                @click="GuardarContanto"
                                                style="background:green"
                                            >
                                                {{ textobotonmodal }}
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-col>
                        </v-row>
                        <v-card-text>
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Buscar"
                                single-line
                                hide-details
                            ></v-text-field>
                            <v-data-table
                                :headers="headers"
                                :items="AllAgenda"
                                :search="search"
                                sort-by="id_agendas"
                                class="elevation-1"
                            >
                                <template v-slot:item.actions="{ item }">
                                    <v-btn
                                        small
                                        class="mr-2"
                                        @click="EditarAgenda(item.id_agendas)"
                                    >
                                        Actualizar
                                    </v-btn>
                                    <v-btn
                                        small
                                        @click="EliminarAgenda(item.id_agendas)"
                                    >
                                        Eliminar
                                    </v-btn>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
export default {
    data () {
        return {
            id_agenda:'',
            textomodal:'',
            textobotonmodal:'',
            menu:false,
            dialog: false,
            rules:{
                caracter: v => v.length <= 100 || 'Maximo 100 caracteres',
                nombrerequerido: value => !!value || 'Requerido.',
                // numerico: value => /[0-9]/.test(value) || 'Ingresar valor númerico',
            },
            data:{
                id_agenda:'',
                nombre:'',
                telefono:'',
                fecha:(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
                direccion:'',
                correo:'',
            },
            search: '',
            headers: [
                { text: 'item',value: 'id_agendas',align: 'left'},
                { text: 'Nombre',value: 'nombre',align: 'left'},
                { text: 'Telefono', value: 'telefono',align: 'left'},
                { text: 'Fecha Nacimiento', value: 'fecha_nacimiento',align: 'center'},
                { text: 'Edad', value: 'edad',align: 'left'},
                { text: 'Direccion', value: 'direccion',align: 'left'},
                { text: 'Correo', value: 'correo',sortable: false,align: 'left'},
                { text: 'Acciones', value: 'actions', sortable: false },
            ],
            AllAgenda: [],
        }
    },
    beforeCreate() {
    },
    created() {
        this.id_agenda == '' ? this.textomodal = 'Nueva Agenda' : '';
        this.id_agenda == '' ? this.textobotonmodal = 'Guardar' : '';
        this.ListarAgenda()
    },
    beforeMount() {

    },
    mounted() {

    },
    methods: {
        GuardarContanto(){
            axios
                .post('/agenda/guardar',this.data)
                .then(response => {
                    response = response.data
                    alert(response.message)
                    if (response.status) {
                        window.location.reload();
                    }
                })
        },
        ListarAgenda(){
            axios
                .get('/agenda/listar/@')
                .then(response => {
                    response = response.data
                    this.AllAgenda = response
                })
        },
        EditarAgenda(id){
            axios
                .get('/agenda/listar/'+id)
                .then(response => {
                    response = response.data
                    this.dialog = true
                    this.data.id_agenda = response.id_agendas
                    this.data.nombre = response.nombre
                    this.data.telefono = response.telefono
                    this.data.fecha = response.fecha_nacimiento
                    this.data.direccion = response.direccion
                    this.data.correo = response.correo
                    this.textomodal = 'Actualizar Agenda de '+ response.nombre
                    this.textobotonmodal = 'Actualizar'
                })
        },
        EliminarAgenda(id){
            axios
                .delete('/agenda/eliminar/'+id)
                .then(response => {
                    response = response.data
                    alert(response.message)
                    if (response.status) {
                        window.location.reload();
                    }
                })
        }
    },
}
</script>

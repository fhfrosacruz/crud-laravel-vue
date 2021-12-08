<template>
  <div>
    <h1 class="text-center">Gerenciar Materiais</h1>
    <hr />

    <!-- Button to Open the Modal -->
    <button @click="modificar=false; abrirModal();" type="button" class="btn btn-primary my-4">Novo Material</button>

    <!-- The Modal -->
    <div class="modal" :class="{mostrar: modal}">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{tituloModal}}</h4>
            <button @click="fecharModal();"  type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="my-4">
              <label for="nome">nome</label>
              <input v-model="material.nome" type="text" class="form-control" id="nome" placeholder="Nome">
            </div>
            <div class="my-4">
              <label for="descricao">descrição</label>
              <textarea v-model="material.descricao" type="text" style="min-width: 100%" class="form-control" id="descricao" placeholder="descrição"></textarea>
            </div>
            <div class="my-4">
              <label for="marca">marca</label>
              <input v-model="material.marca" type="text" class="form-control" id="marca" placeholder="marca">
            </div>
            <div class="my-4">
              <label for="valor">valor</label>
              <input v-model="material.valor" type="text" onkeypress='return event.charCode >= 44 && event.charCode <= 57' class="form-control" id="valor" placeholder="valor">
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button @click="fecharModal();" type="button" class="btn btn-secondary" data-dismiss="modal">
              Cancelar
            </button>
            <button  @click="guardar();" type="button" class="btn btn-success" data-dismiss="modal">
              Guardar
            </button>


          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">Descrição</th>
          <th scope="col">Marca</th>
          <th scope="col">Valor</th>
          <th scope="col" colspan="2" class="text-center">Ação</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="mat in material" :key="mat.id">
          <th scope="row">{{ mat.id }}</th>
          <td>{{ mat.nome }}</td>
          <td>{{ mat.descricao }}</td>
          <td>{{ mat.marca }}</td>
          <td>{{ mat.valor }}</td>
          <td>
            <button  @click="modificar=true; abrirModal(mat);" class="btn btn-warning">Editar</button>
          </td>
          <td>
            <button @click="eliminar(mat.id)" class="btn btn-danger">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      material:{  
        id:0,      
        nome:'yy',
        descricao:'yuu',
        marca:'errr',
        valor:1,
      },
      id:0,
      modificar:true,
      modal:0,
      tituloModal:'',
      material: [],
    };
  },
  methods: {
    async listar() {
      const res = await axios.get('/material');
      this.material = res.data;
    },
    async eliminar(id) {
      const res = await axios.delete('/material/' + id);
      this.listar();
    },
    async guardar() {
      if(this.modificar){
                      
        const res = await axios.put('/material/'+this.id, this.material);
        console.log('editar',this.id);
      }else{
        const res = await axios.post('/material/', this.material);
        console.log('criar',this.material);
      }
      this.fecharModal();
      this.listar();
    },
    abrirModal(data={}){
      this.modal=1;
      if(this.modificar){
        this.id=data.id;
        this.tituloModal="Modificar material";
        this.material.nome=data.nome;
        this.material.descricao=data.descricao;
        this.material.marca=data.marca;
        this.material.valor=data.valor;
      }else{
        this.id=0;
        this.tituloModal="Criar Material";
        this.material.nome='';
        this.material.descricao='';
        this.material.marca='';
        this.material.valor='';
      }
    },
    fecharModal(){
      this.modal=0;
    },
  },
  created() {
    this.listar();
  },
};
</script>

<style>
  .mostrar{
    display: list-item;
    opacity: 1;
    background: rgba(75, 56, 143, 0.705);
  }
</style>
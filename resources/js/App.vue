<template>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  </head>
  <div id="app">
    <h1>Hello world!</h1>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Status</th>
          <th>Download</th>
        </tr>
      </thead>
      <tbody>
        <Document v-for="doc in documents" :key="doc.id" :document="doc" />
      </tbody>
    </table>
    <button @click="erakutsi = !erakutsi">Gehitu dokumentua</button>
    <br>
    <br>

    <div v-show="erakutsi">
      <form @submit.prevent="dokumentuaGehitu">
        <label>Izena</label>
        <input type="text" v-model="formData.name" />
        <br>
        <label>Path</label>
        <input type="text" v-model="formData.path" />
        <br>
        <label>Deskargatu</label>
        <input type="checkbox" v-model="formData.can_download" />
        <br>
        <label>Aktibatu</label>
        <input type="checkbox" v-model="formData.active" />
        <button :disabled="!ahalGehitu">Bidali</button>
      </form>
    </div>

    <br>
    <br>
    <button @click="apiDokumentuak">Api dokumentuak</button>
  </div>
</template>

<script>
  import Document from './components/Document.vue'
  import axios from 'axios'

  export default {
    name: 'App',
    data() {
      return {
        erakutsi: false,
        formData: {
          name: '',
          path: '',
          can_download: false,
          active: false,
          
        },
        documents: []
      }
    },
    computed: {
      ahalGehitu() {
        return (
          this.formData.name.trim() !== '' && this.formData.path.trim() !== ''
        );
      }
    },
    methods: {
      dokumentuaGehitu() {
        const dokumentuBerria = {
          id: this.documents.length + 1,
          ...this.formData,
        };
        this.documents.push(dokumentuBerria);
        this.garbituForm();
      },
      garbituForm() {
        this.formData = {
          name: '',
          path: '',
          can_download: false,
          active: false,
        };
      },
      async apiDokumentuak(){
        try {
          const res = await axios.post('/api/documents', {
            documents: this.documents
          });
          console.log('Dokumentuak bidali dira:', res.data);
        } catch (error) {
          console.log('Errorea dokumentuak bidaltzerakoan:', error);
        }
      },
      async jasoDokumentuak(){
        try {
          const res = await axios.get('api/documents');
          this.documents = res.data;
          console.log('Dokumentuak jaso dira:', res.data);
        } catch (error){
          console.error('Errorea dokumentuak jasotzerakoan:', error);
        }
      },
    },
    components: {
      Document,
    },
    mounted() {
      this.jasoDokumentuak();
    }, 
  }
</script>

<style>

</style>
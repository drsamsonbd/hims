<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard>
        <CCardHeader>
          User id:  {{ $route.params.id }}
        </CCardHeader>
        <CCardBody>
          <CDataTable 
            striped 
            small 
            fixed
            :items="items" 
            :fields="fields"
          >
            <template slot="value" slot-scope="data">
              <strong>{{data.item.value}}</strong>
            </template>
          </CDataTable>  
          <CForm>
            <input type="text" class="form-control" id="InputIC" v-model="ic" hidden>
          </CForm>
        </CCardBody>
        <CCardFooter>
          <CButton color="primary" @click="goBack">Back</CButton>
          <CButton color="danger" v-on:click="reset()">Reset Password</CButton>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'User',
  data: () => {
    return {
      items: [],
      item: '',
      fields: [
        {key: 'key'},
        {key: 'value'},
      ],
      
        ic:null,
      
    }
  },
  methods: {
    getUserData (id) {
      const user = usersData.find((user, index) => index + 1 == id)
      const userDetails = user ? Object.entries(user) : [['id', 'Not found']]
      return userDetails.map(([key, value]) => { return { key, value } })
    },
    goBack() {
      this.$router.go(-1)
    },
    getIC(){     
         let self = this; 
         axios.get(  this.$apiAdress + '/api/users/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
       .then(({data}) => (this.ic = data.ic)).catch(function (error) {
      console.log(error);
      self.$router.push({ path: '/login' });
    });
 
      },

          reset() {
      if(confirm("Do you really want to reset?")){
           let self = this;
      axios.post(this.$apiAdress + '/api/users/reset/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
            {
            _method: 'POST',
           ic: self.ic,
        }
      
      ) 
      .then(function (response) {
         alert('Successfully reset user password.');
    
      }).catch(function (error) {
        console.log(error);
        alert('Error')
      });
      }
    },
       
     },
       
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/users/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
      const items = Object.entries(response.data);
      self.items = items.map(([key, value]) => {return {key: key, value: value}});
     
    }).catch(function (error) {
      console.log(error);
      self.$router.push({ path: '/login' });
    });

     this.getIC();
  }
}
</script>

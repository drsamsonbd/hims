 <template>
    <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">
      <CCard>
        <CCardHeader>
           Pesakit Aktif
        </CCardHeader>
        <CCardBody>
          <CSelect
                    :value.sync="pkrc"
                  label="PKRC"
                    :options="['','Dewan Kelab Belia Sukan', 'Dewan Kg. Sungai Nangka']"
                  description="Sila pilih fasiliti"
                >
                 <template #append>
                    <CButton color="primary" @click="getPatient()">Pilih</CButton>
                  </template>     
          </CSelect>
      
          <CDataTable
            sorter
            column-filter
            hover
            striped
            :items="items"
            :fields="fields"
            :items-per-page="10"
            pagination
            v-if="!isHidden"

          >
     
          <template #view="{item}">
            <td>
              <CButton color="primary" @click="ViewPatient( item.id )"><CIcon name="cib-facebook"/></CButton>
            </td>
          </template>
      
      
        </CDataTable>
        </CCardBody>
      </CCard>
      </transition>
    </CCol>
  </CRow>
</template>



<script type="text/javascript">
import axios from 'axios'
export default {
     name: 'Aktif',
          data:()=>{
      return{
    
     items: [],
       fields: [     
           { key: 'id', label: 'ID', sortable: true, sortDirection: 'asc' },       
          { key: 'date', label: 'Tarikh Kemasukan', sortable: true, sortDirection: 'asc' },          
          { key: 'time', label: 'Masa', sortable: true, sortDirection: 'asc' },
          { key: 'reg_number', label: 'RN', sortable: true, sortDirection: 'asc' },
          { key: 'name', label: 'Nama', sortable: true, sortDirection: 'asc' },
          { key: 'kp_passport', label: 'No. Kad Pengenalan/Passport', sortable: true, sortDirection: 'desc' },
          { key: 'age', label: 'Umur', sortable: true, sortDirection: 'desc' },
          { key: 'gender', label: 'Jantina', sortable: true, sortDirection: 'desc' },
          { key: 'pkrc', label: 'PKRC', sortable: true, sortDirection: 'desc' },
            { key: 'view', label: 'View' },
          { key: 'discharge', label: 'Discaj' },
        ],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      you: null,
      isHidden: true,
      pkrc:'',
        
      }
 
    }, 
      paginationProps: {
    align: 'center',
    doubleArrows: false,
    previousButtonHtml: 'prev',
    nextButtonHtml: 'next'
      },
    methods: {
      getPatient (){
    this.isHidden = false;
      let self = this;
      axios.get(this.$apiAdress + '/api/activepkrc/' + '?token=' + localStorage.getItem("api_token"),  { params: { pkrc: this.pkrc } })
      .then(function (response) {
        self.items = response.data.active;
        self.you = response.data.you;
      }).catch(function (error) {
        console.log(error);
         alert('Unauthorized!');
      });
    },
 
       ViewPatient(id) {
     this.$router.push({name:'ViewPatient', params: {id:id}}); 
    },
   
  },
  // mounted(){
  //     this.getPatient();
    //}
}
 </script>


<style type="text/css">

</style>
 <template>
    <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">
      <CCard>
        <CCardHeader>
           Pesakit Aktif
        </CCardHeader>
        <CCardBody>
      
          <CDataTable
            sorter
            column-filter
            hover
            striped
            :items="items"
            :fields="fields"
            :items-per-page="10"
            pagination
            @row-clicked="view(item.id)"

          >
          <template #status="{item}">
            <td>
              <CBadge :color="getBadge(item.status)">{{ item.status }}</CBadge>
            </td>
          </template>
              <template #edit="{item}">
            <td>
              <CButton color="primary" @click="editUser( item.id )">Edit</CButton>
            </td>
          </template>
          <template #discharge="{item}"  sytle="align:center">
            <td >
              <CButton color="danger" @click="discharge( item.id )">Discaj</CButton>
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
          { key: 'date', label: 'Tarikh Kemasukan', sortable: true, sortDirection: 'asc' },          
          { key: 'time', label: 'Masa', sortable: true, sortDirection: 'asc' },
          { key: 'reg_number', label: 'RN', sortable: true, sortDirection: 'asc' },
          { key: 'name', label: 'Nama', sortable: true, sortDirection: 'asc' },
          { key: 'kp_passport', label: 'No. Kad Pengenalan/Passport', sortable: true, sortDirection: 'desc' },
          { key: 'age', label: 'Umur', sortable: true, sortDirection: 'desc' },
          { key: 'gender', label: 'Jantina', sortable: true, sortDirection: 'desc' },
          { key: 'pkrc', label: 'PKRC', sortable: true, sortDirection: 'desc' },
     
          { key: 'discharge', label: 'Discaj' },
        ],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      you: null,
        
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
      let self = this;
      axios.get(this.$apiAdress + '/api/activepatients/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
      .then(function (response) {
        self.items = response.data.view;
      }).catch(function (error) {
        console.log(error);
         alert('Unauthorized!');
      });
    },
   
  },
    mounted(){
        this.getPatient();
}
}
 </script>


<style type="text/css">

</style>
<template>
  <div class="d-flex align-items-center min-vh-100">
    <CContainer fluid>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCard class="mx-4 mb-0">
            <CCardBody class="p-4">
              <CForm @submit.prevent="register" method="POST">
                <h1>Register</h1>
                <p class="text-muted">Create your account</p>
                <CInput
                  placeholder="Username"
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="username"
                  v-model="name"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  placeholder="Email"
                  prepend="@"
                  autocomplete="email"
                  v-model="email"
                />
                  <CInput
                  placeholder="IC"
                  prependHtml="<i class='cui-ID'></i>"
                  autocomplete="ic"
                  v-model="ic"
                > <template #prepend-content><CIcon name="cil-ID"/></template>
                  </CInput>
                <CInput
                  placeholder="Password"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  v-model="password"
                >
                  <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                </CInput>
                <CInput
                  placeholder="Repeat password"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  class="mb-4"
                  v-model="password_confirmation"
                >
                  <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                </CInput>
                 <CInput
                  placeholder="Roles"
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="menuroles"
                  class="mb-4"
                  v-model="menuroles"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CButton type="submit" color="success" block>Create Account</CButton>
                    <CButton @click="back()" color="primary" block>Back</CButton>
              </CForm>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

  <script>
    import axios from 'axios'
    export default {
      data() {
        return {
          name: '',
          email: '',
          ic:'',
          password: '',
          password_confirmation: '',
          menuroles:'',
          items:[]
        }
      },    
      methods: {
         back() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
        register() {
          var self = this;
          axios.post(  this.$apiAdress + '/api/register'+ '?token='+ localStorage.getItem("api_token"), {
            name: self.name,
            email: self.email,
            ic: self.ic,
            password: self.password,
            password_confirmation: self.password_confirmation,
            menuroles: self.menuroles
          }).then(function (response) {
            self.name = '';
            self.email = '';
            self.ic='';
            self.password = '';
            self.password_confirmation = '';
            self.menuroles='';
            console.log(response);
            self.$router.push({ path: '/users' });
          })
          .catch(function (error) {
            console.log(error);
             alert('Invalid Data Entry')
          });
  
        },
            getUsers (){
      let self = this;
      axios.get(  this.$apiAdress + '/api/users?token=' + localStorage.getItem("api_token"))
      .then(function (response) {
        self.you = response.data.you;
      }).catch(function (error) {
        console.log(error);
         alert('Unauthorized!');              
      self.$router.push({ path: '/login' });
      });
    }
  },
  mounted: function(){
    this.getUsers();
  }
      }
  
  
  </script>

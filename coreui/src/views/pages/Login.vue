<template>
  <CContainer class="d-flex content-center min-vh-100">
    <CRow>
      <CCol>
        <CCardGroup>
          <CCard class="p-6">
            <CCardBody>
              <CForm @submit.prevent="login" method="POST">
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <CInput
                  v-model="ic"
                  prependHtml="<i class='cui-user'></i>"
                  placeholder="No. Kad Pengenalan"
                  autocomplete="ic"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  v-model="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  placeholder="Password"
                  type="password"
                  autocomplete="curent-password"
                >
                  <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                </CInput>
                <CRow>
                  <CCol col="6">
                    <CButton type="submit" color="primary" class="px-4">Login</CButton>
                  </CCol>
              
                </CRow>
              </CForm>
            </CCardBody>
          </CCard>
   
        </CCardGroup>
      </CCol>
    </CRow>
  </CContainer>
</template>

<script>

import axios from "axios";

    export default {
      name: 'Login',
      data() {
        return {
          ic: '',
          password: '',
          showMessage: true,
          message: '',
        }
      },
      methods: {
       
        login() {
          let self = this;
          axios.post('/api/login', {
           ic: self.ic,
            password: self.password,
          }).then(function (response) {
            self.ic = '';
            self.password = '';
            localStorage.setItem("api_token", response.data.access_token);
            localStorage.setItem('roles', response.data.roles);
            localStorage.setItem('user', response.data.name);
            self.$router.push({ path: 'dashboard' });
          })
          .catch(function (error) {
            self.message = 'Incorrect IC or password';
            self.showMessage = true;
            console.log(error);
          });
  
        }
      }
    }

</script>

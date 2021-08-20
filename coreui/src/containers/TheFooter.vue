<template>
  <CFooter :fixed="false">
    <div>
      <span>Dr. Samson Bd Mokuntil</span>
      <span class="ml-1">&copy; {{new Date().getFullYear()}} Hospital Beluran.</span>
    </div>
    <div class="ml-auto">
      <span class="mr-1">Powered by</span>
      <a href="https://qmed.asia" target="_blank">Qmed.asia</a>
    </div>
  </CFooter>
</template>

<script>
export default {
  name: 'TheFooter'
}
</script>

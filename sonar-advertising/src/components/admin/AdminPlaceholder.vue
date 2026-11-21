<template>
  <div class="admin-placeholder">
    <div class="placeholder-content">
      <h1>Admin Panel</h1>
      <p>This section is under development</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminPlaceholder'
}
</script>

<style scoped>
.admin-placeholder {
  min-height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}

.placeholder-content {
  text-align: center;
  color: #666;
}

.placeholder-content h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.placeholder-content p {
  font-size: 1.2rem;
}
</style>
<script setup>
console.log("Hello from Join.vue");
</script>

<template>
    <form
        action="http://localhost:3000/api/theater-groups"
        method="POST"
        enctype="multipart/form-data"
    >
        <input type="file" name="image" />
        <button type="submit">Submit</button>
    </form>
</template>

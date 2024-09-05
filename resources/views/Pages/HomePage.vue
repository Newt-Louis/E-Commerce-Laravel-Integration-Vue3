<template>
    <div class="container">
        <h1>Trang Chủ Client</h1>
        <button @click="gotoAbout">let's go</button>
        <Input />
    </div>
</template>

<script>
import Input from "../Components/Input.vue";

export default {
    methods: {
        gotoAbout() {
            this.$router.push("/about");
        },
    },
    components: {
        Input,
    },
};
</script>

<style></style>

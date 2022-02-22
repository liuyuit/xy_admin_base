<template>
    <div>
        <h1>Hello, Laravue</h1>
        <p class="hello">{{ msg }}}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            msg: 'this is a Laravel with Vue and Element demo.'
        }
    }
}
</script>

<style>
.hello {
    font-size: 2em;
    color: #1f9d55;
}
</style>

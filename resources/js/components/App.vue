<template>
    <div id ="app">
        {{ message }}
            <calendar :start="'1989-10-01'" :start-at="startAt" :end="'1990-01-01'" :day-callback="meow" ></calendar>

    </div>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                startAt: '1989-10-01',
                meow($col) {
                    this.startAt = $col;
                }
            }
        }
    }
    
</script>

<style scoped>

</style>
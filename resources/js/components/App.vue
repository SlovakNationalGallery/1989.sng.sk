<template>
    <div id ="app">
        <calendar :start="'1989-10-01'" :start-at="startAt" :end="'1990-01-01'" :day-callback="updateDay" ></calendar>
    </div>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                startAt: '1989-10-01',
                updateDay($day) {
                    this.startAt = $day;
                }
            }
        }
    }
</script>

<style scoped>

</style>
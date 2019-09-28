<template>
  <div class="cldr-months-wrapper">
    <div class="cldr-week-wrapper" v-for="(week, wi) in weeks" :key="wi">
      <span class="cldr-week">{{ week.w }}.</span>
      <div class="cldr-days-wrapper">
        <div
          v-for="(day, di) in week.days"
          :key="day.d"
          :class="dayClasses(day)"
          @click="setDay(day.d)"
          class="cldr-day-wrapper"
        >
          <div class="cldr-day" :class="{ weekend: day.dw > 5 }">
            <span>{{ day.dt }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MonthsView",
  props: {
    days: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      weeks: [...new Set(this.days.filter(d => d.active).map(d => d.w))].map(
        w => ({
          w,
          days: this.days.filter(d => d.w === w)
        })
      )
    };
  },
  methods: {
    dayClasses(d) {
      return {
        shaded: d.m % 2,
        inactive: !d.active
      };
    },
    setDay(d){
      this.$emit('input', d);
    }
  }
}
</script>
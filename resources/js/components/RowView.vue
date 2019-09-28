<template>
  <div class="cldr-row">
    <button @click="prevPeriod()">〈</button>
      <div class="cldr-days-wrap">
        <transition-group name="list" :class="direction">
          <div
            class="cldr-row-day"
            v-for="(day, i) in days"
            :key="day.d"
            :class="{ inactive: !day.active, selected: day.d === selectedDay }"
            :style="{
              left: (100 * (i - selectedIndex + middle)) / displayCount + '%'
            }"
            @click="day.active && selectDay(day)"
          >
            {{ day.dt }}. {{ day.m }}.
          </div>
        </transition-group>
      </div>
    <button @click="nextPeriod()">〉</button>
  </div>
</template>

<script>
export default {
  name: "RowView",
  props: {
    startAt: {
      type: String,
      required: true
    },
    displayCount: {
      type: Number,
      default: 7
    },
    days: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      selectedIndex: this.startAt
        ? this.days.findIndex(a => a.d === this.startAt)
        : this.days.findIndex(a => a.active),
      middle: Math.floor(this.displayCount / 2),
      direction: "left",
      cnt: this.displayCount * 3
    };
  },
  watch: {
    startAt() {
      this.selectedIndex = this.startAt
        ? this.days.findIndex(a => a.d === this.startAt)
        : this.days.findIndex(a => a.active);
    }
  },
  computed: {
    selectedDay() {
      return (
        this.startAt &&
        this.days[this.selectedIndex] &&
        this.days[this.selectedIndex].d
      );
    },
    startIndex() {
      return this.days.findIndex(a => a.active);
    },
    endIndex() {
      return this.days.findIndex(a => a.d > this.startAt && !a.active) - 1;
    }
  },
  methods: {
    prevPeriod() {
      this.direction = "right";
      this.selectedIndex = Math.max(
        this.selectedIndex - this.displayCount,
        this.startIndex
      );
    },
    nextPeriod() {
      this.direction = "left";
      this.selectedIndex = Math.min(
        this.selectedIndex + this.displayCount,
        this.endIndex
      );
    },
    selectDay(d) {
      const target = this.days.indexOf(d);
      this.direction = target > this.selectedIndex ? "left" : "right";
      this.selectedIndex = target;
      this.$emit("input", d.d);
    }
  }
};
</script>

<style lang="scss">

.cldr-row {
  position: relative;
}
.cldr-row button {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  width: 5vw;
}
.cldr-row button:last-child {
  right: 0;
  left: auto;
}
.cldr-days-wrap {
  position: relative;
  left: 10vw;
  width: 80vw;
  height: 2.5em;
  overflow-x: hidden;
}

.cldr-row-day {
  display: inline-block;
  position: absolute;
  margin: 0;
  top: 0;
  width: calc(80vw / 9);
  max-width: calc(80vw / 9);
  height: 2.5em;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  cursor: pointer;
  text-align: center;
  transition: all 0.5s;

  /* transition: background-color 0.1s ease-in-out; */
}

.cldr-row-day.selected {
  background: red;
}
.cldr-row-day.inactive {
  color: #aaa;
  pointer-events: none;
}
</style>

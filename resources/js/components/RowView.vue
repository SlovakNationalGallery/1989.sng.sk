<template>
  <div class="cldr-row">
    <button @click="prevPeriod()">〈</button>
    <carousel
      class="carousel"
      :navigateTo="navigateTo"
      :scrollPerPage="false"
      :paginationEnabled="false"
      :mouse-drag="false"
      :perPage="perPage"
    >
      <slide v-for="(day, i) in days" :key="day.d">
        <calendar-day
          class="day"
          :date="day.d"
          :active="day.active"
          :selected="selectedIndex === i"
          @click="onSlideClick(i)"
        ></calendar-day>
      </slide>
    </carousel>
    <button @click="nextPeriod()">〉</button>
  </div>
</template>

<script>
import CalendarDay from './Calendar/Day'
import { Carousel, Slide } from 'vue-carousel';

export default {
  name: "RowView",
  components: { CalendarDay, Carousel, Slide },
  props: {
    startAt: {
      type: String,
      required: true
    },
    days: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      selectedIndex: this.days.findIndex(({d}) => this.startAt === d),
      perPage: 5,
      initialNavigateToDone: false,
    };
  },
  created() {
    this.updatePerPage();

    this.onWindowResize = _.debounce(this.updatePerPage, 200)
    window.addEventListener("resize", this.onWindowResize);
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.onWindowResize);
  },
  watch: {
    selectedIndex() {
      this.$emit("change", this.days[this.selectedIndex].d);
    }
  },
  computed: {
    navigateTo() {
      if (!this.initialNavigateToDone) {
        this.initialNavigateToDone = true
        return [this.selectedIndex - this.navigationOffset, false]
      }

      return [this.selectedIndex - this.navigationOffset, true]
    },
    navigationOffset() {
      return (this.perPage - 1) / 2
    },
  },
  methods: {
    prevPeriod() {
      this.selectedIndex = Math.max(this.selectedIndex - this.perPage, 0 + this.navigationOffset)
    },
    nextPeriod() {
      this.selectedIndex = Math.min(this.selectedIndex + this.perPage, this.days.length - this.navigationOffset - 1)
    },
    onSlideClick(index) {
      this.selectedIndex = index
    },
    updatePerPage() {
      function minSize(daysCount) {
        const dayWidth = 50
        const gutter = 10
        const buttonWidth = 40
        // This needs to be kept in sync with CSS dimensions under .cldr-row
        return daysCount * (dayWidth + gutter) + 2 * (buttonWidth + 3 * gutter)
      }

      if (window.innerWidth > minSize(9)) return this.perPage = 9
      if (window.innerWidth > minSize(7)) return this.perPage = 7
      if (window.innerWidth > minSize(5)) return this.perPage = 5
      if (window.innerWidth > minSize(3)) return this.perPage = 3

      return this.perPage = 1
    },
  }
};
</script>

<style lang="scss" scoped>
.cldr-row {
  $day-width: 60px;
  $gutter: 10px;
  $button-width: 40px;

  display: flex;
  justify-content: center;

  button {
    width: $button-width;
    height: $day-width;
    color: white;
  }

  .carousel {
    display: flex;
    margin-left: 2 * $gutter;
    margin-right: 2 * $gutter;
    width: 9 * ($day-width + $gutter) - $gutter;

    @media screen and (width: 9 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      width: 7 * ($day-width + $gutter) - $gutter;
    }
    @media screen and (width: 7 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      width: 5 * ($day-width + $gutter) - $gutter;
    }
    @media screen and (width: 5 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      width: 3 * ($day-width + $gutter) - $gutter;
    }
    @media screen and (max-width: 2 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      width: 1 * ($day-width + $gutter) - $gutter;
    }
  }

  .day {
    flex-shrink: 0;
    margin-left: $gutter;
    width: $day-width;
    height: $day-width;

    &:first-child {
      margin-left: 0;
    }
  }
}
</style>

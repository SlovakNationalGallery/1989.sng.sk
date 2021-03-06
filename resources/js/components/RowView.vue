<template>
  <div class="cldr-row px-4" :class="{ dark }">
    <carousel
      class="carousel"
      ref="carousel"
      v-if="this.days.length > 0"
      :navigate-to="navigateTo"
      :navigation-enabled="true"
      :pagination-enabled="false"
      :navigation-next-label="`<a class='btn btn-link text-light px-0'>&gt;</a>`"
      :navigation-prev-label="`<a class='btn btn-link text-light px-0'>&lt;</a>`"
      :scroll-per-page="false"
      :mouse-drag="false"
      :touch-drag="false"
      :per-page="3"
      :per-page-custom="perPageBreakpoints"
    >
      <slide v-for="(day, i) in days" :key="day.d">
        <calendar-day
          :dark="dark"
          :date="day.d"
          :disabled="!day.active"
          :active="selectedIndex === i"
          @click="onSelectedDayChange(i)"
        ></calendar-day>
      </slide>
    </carousel>
  </div>
</template>

<script>
import CalendarDay from "./Calendar/Day";
import { Carousel, Slide } from "vue-carousel";
import { isEmpty, debounce } from "lodash";

export default {
  name: "RowView",
  components: { CalendarDay, Carousel, Slide },
  props: {
    days: {
      type: Array,
      required: true
    },
    currentDate: {
      type: String,
      required: true
    },
    dark: {
      type: Boolean,
    }
  },
  data() {
    return {
      navigateTo: [],
      perPageBreakpoints: [
        [768, 7],
        [525, 6],
        [425, 5],
        [375, 4],
      ]
    };
  },
  created() {
    this.onWindowResize = debounce(this.navigateToCurrentDate.bind(this, false), 100);
    window.addEventListener("resize", this.onWindowResize);
  },
  mounted() {
    this.navigateToCurrentDate(false);
  },
  destroyed() {
    window.removeEventListener("resize", this.onWindowResize);
  },
  computed: {
    selectedIndex() {
      return this.days.findIndex(({ d }) => this.currentDate === d);
    },
  },
  watch: {
    days(newDays, oldDays) {
      // Update navigation state if days have changed (e.g. after removing a filter)
      if (_.isEqual(newDays, oldDays)) return;
      this.navigateToCurrentDate();
    },
    currentDate() {
      // Re-navigate to account for race conditions
      if (this.navigateTo.length > 0) this.navigateToCurrentDate()
    }
  },
  methods: {
    onSelectedDayChange(selectedIndex) {
      this.navigateTo = []
      this.$emit("change", this.days[selectedIndex].d);
    },

    navigateToCurrentDate(animateNavigation) {
      const animate = (animateNavigation === undefined) ? true : animateNavigation;
      const daysPerPage = this.daysPerPage()
      const leftOffset = Math.floor(daysPerPage / 2)

      // Navigate to first element if there's no more pages
      if (this.days.length < daysPerPage) {
        this.navigateTo = [0, animate]
        return
      }

      // Navigation to last element does not work -- go few elements before it
      const lastNavigateableIndex = this.days.length - daysPerPage
      if (this.selectedIndex - leftOffset > lastNavigateableIndex) {
        this.navigateTo = [lastNavigateableIndex, animate]
        return
      }

      // By default, navigate so that selected element is centered
      this.navigateTo = [Math.max(0, this.selectedIndex - leftOffset), animate]
    },

    daysPerPage() {
      if (this.$refs.carousel) return this.$refs.carousel.currentPerPage;

      const windowWidth = window.innerWidth;
      const breakpoint = this.perPageBreakpoints.find(([width, perPageCount]) => windowWidth >= width)
      if (breakpoint) return breakpoint[1]
      return 1
    }
  }
};
</script>

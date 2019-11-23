<template>
  <div class="cldr-row">
    <carousel
      class="carousel"
      ref="carousel"
      v-if="this.days.length > 0"
      :navigate-to="navigateTo"
      :navigation-enabled="true"
      :pagination-enabled="false"
      :navigation-next-label="`<a class='btn btn-link text-light'>&gt;</a>`"
      :navigation-prev-label="`<a class='btn btn-link text-light'>&lt;</a>`"
      :scroll-per-page="false"
      :mouse-drag="false"
      :touch-drag="false"
      :per-page="1"
      :per-page-custom="perPageBreakpoints"
    >
      <slide v-for="(day, i) in days" :key="day.d">
        <calendar-day
          :class="dayClass || 'btn-outline-light'"
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
import { isEmpty } from "lodash";

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
    dayClass: {
      type: String,
    }
  },
  data() {
    return {
      navigateTo: [],
      perPageBreakpoints: [
        [1200, 7],
        [768, 5],
        [576, 3],
        [425, 2],
      ]
    };
  },
  mounted() {
    this.navigateToCurrentDate(false);
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

      // Navigate to first element if there's no more pages
      if (this.days.length < this.daysPerPage()) {
        this.navigateTo = [0, animate]
        return
      }

      // Navigation to last element does not work -- go few elements before it
      if (this.selectedIndex > this.days.length - this.daysPerPage()) {
        this.navigateTo = [this.days.length - this.daysPerPage(), animate]
        return
      }

      this.navigateTo = [this.selectedIndex, animate]
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

<style lang="scss">
@import '~bootstrap/scss/bootstrap';

.cldr-row {
  margin-left: 52px;
  margin-right: 52px;

  .carousel {
    .VueCarousel-slide {
      text-align: center;
    }

    .VueCarousel-navigation--disabled > *{
      @extend .disabled
    }

    .VueCarousel-navigation-button > * {
      text-decoration: none;
      font-size: 2rem;
    }
  }

  &.dark {
    & .VueCarousel-navigation-button > * {
      @extend .text-dark
    }
  }
}
</style>

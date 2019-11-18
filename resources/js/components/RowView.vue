<template>
  <div class="cldr-row">
    <button
      class="btn"
      v-if="showButtons"
      @click="prevPeriod()"
      :disabled="selectedIndex - navigationOffset <= firstNavigateableIndex"
    >
      〈
    </button>
    <carousel
      class="carousel"
      :navigateTo="navigateTo"
      :scrollPerPage="false"
      :paginationEnabled="false"
      :mouseDrag="false"
      :touchDrag="false"
      :perPage="perPage"
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
    <button
      class="btn"
      v-if="showButtons"
      @click="nextPeriod()"
      :disabled="selectedIndex + navigationOffset >= lastNavigateableIndex"
    >
      〉
    </button>
  </div>
</template>

<script>
import CalendarDay from "./Calendar/Day";
import { Carousel, Slide } from "vue-carousel";

export default {
  name: "RowView",
  components: { CalendarDay, Carousel, Slide },
  props: {
    days: {
      type: Array,
      required: true
    },
    selectedDay: {
      type: String,
      required: true
    },
    dayClass: {
      type: String,
    }
  },
  data() {
    return {
      perPage: 5,
      showButtons: true,
      initialNavigateToDone: false
    };
  },
  created() {
    this.updatePerPage();

    this.onWindowResize = _.debounce(this.updatePerPage, 200);
    window.addEventListener("resize", this.onWindowResize);
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.onWindowResize);
  },
  computed: {
    selectedIndex() {
      return this.days.findIndex(({ d }) => this.selectedDay === d)
    },
    navigateTo() {
      if (!this.initialNavigateToDone) {
        this.initialNavigateToDone = true;
        return [this.selectedIndex - this.navigationOffset, false];
      }

      return [Math.max(this.selectedIndex - this.navigationOffset, 0), true];
    },
    navigationOffset() {
      return (this.perPage - 1) / 2;
    },
    firstNavigateableIndex() {
      return _.findIndex(this.days, "active");
    },
    lastNavigateableIndex() {
      return _.findLastIndex(this.days, "active");
    }
  },
  methods: {
    prevPeriod() {
      this.onSelectedDayChange(Math.max(
        this.selectedIndex - this.perPage,
        this.firstNavigateableIndex
      ));
    },
    nextPeriod() {
      this.onSelectedDayChange(Math.min(
        this.selectedIndex + this.perPage,
        this.lastNavigateableIndex
      ));
    },
    onSelectedDayChange(selectedIndex) {
       this.$emit("change", this.days[selectedIndex].d);
    },
    updatePerPage() {
      if (window.innerWidth >= 768) {
        this.perPage = 7;
        this.showButtons = true;
        return
      }

      if (window.innerWidth >= 425) {
        this.perPage = 3;
        this.showButtons = true;
        return
      }

      this.perPage = 3;
      this.showButtons = false;
    }
  }
};
</script>

<style lang="scss">
@import '~bootstrap/scss/bootstrap';

.cldr-row {
  $day-slide-width: 85px;
  user-select: none;
  display: flex;
  justify-content: center;
  padding: 0.2rem;

  & > button {
    height: 76px;
    color: white;
    border: none;
    font-size: 3rem;
    font-weight: bold;
    opacity: 0.8;

    &:hover {
      opacity: 1;
      color: white;
    }

    &:disabled {
      opacity: 0.2;
    }
  }

  .carousel {
    margin-left: 20px;
    margin-right: 20px;
    width: 3 * $day-slide-width;

    @media screen and (min-width: 768px) {
      width: 7 * $day-slide-width;
    }


    .VueCarousel-slide {
      width: $day-slide-width;
      text-align: center;
    }
  }

  &.dark {
    & > button {
      @extend .text-dark
    }
  }
}
</style>

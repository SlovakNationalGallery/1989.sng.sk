<template>
  <div class="cldr-row">
    <button class="btn"
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
    <button class="btn"
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
      selectedIndex: this.days.findIndex(({ d }) => this.startAt === d),
      perPage: 5,
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
  watch: {
    selectedIndex() {
      this.$emit("change", this.days[this.selectedIndex].d);
    },
    $route(to) {
      const toIndex = this.days.findIndex(({ d }) => to.params.date === d);
      if (toIndex != this.selectedIndex) {
        this.selectedIndex = toIndex;
      }
    }
  },
  computed: {
    navigateTo() {
      if (!this.initialNavigateToDone) {
        this.initialNavigateToDone = true;
        return [this.selectedIndex - this.navigationOffset, false];
      }

      return [this.selectedIndex - this.navigationOffset, true];
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
      this.selectedIndex = Math.max(
        this.selectedIndex - this.perPage,
        this.firstNavigateableIndex
      );
    },
    nextPeriod() {
      this.selectedIndex = Math.min(
        this.selectedIndex + this.perPage,
        this.lastNavigateableIndex
      );
    },
    onSlideClick(index) {
      this.selectedIndex = index;
    },
    updatePerPage() {
      if (window.innerWidth >= 1024) return (this.perPage = 7);
      if (window.innerWidth >= 768) return (this.perPage = 5);
      if (window.innerWidth >= 425) return (this.perPage = 3);

      return (this.perPage = 1);
    }
  }
};
</script>

<style lang="scss">
.cldr-row {
  $day-slide-width: 85px;
  user-select: none;
  display: flex;
  justify-content: center;

  button {
    width: 80px;
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
    width: $day-slide-width;

    @media screen and (min-width: 425px) {
      width: 3 * $day-slide-width;
    }

    @media screen and (min-width: 768px) {
      width: 5 * $day-slide-width;
    }

    @media screen and (min-width: 1024px) {
      width: 7 * $day-slide-width;
    }

    .VueCarousel-slide {
      width: $day-slide-width;
      text-align: center;
    }
  }
}
</style>

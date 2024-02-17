function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    )
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false
    },


    // profile menu

    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },

// dropdown menu

    isDdownMenuOpen: false,
    toggleDdownMenu() {
      this.isDdownMenuOpen = !this.isDdownMenu
    },
    closeDdownMenu() {
      this.isDdownMenuOpen = false
    },


    // page menu
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen
    },

// Overview page menu 
    isOverviewPagesMenuOpen: false,
    toggleOverviewPagesMenu() {
      this.isOverviewPagesMenuOpen = !this.isOverviewPagesMenuOpen
    },

    // Transection menu 
    isTransectionMenuOpen: false,
    toggleTransectionMenu() {
      this.isTransectionMenuOpen = !this.isTransectionMenuOpen
    },

    // Overview page menu 
    isRolePagesMenuOpen: false,
    toggleRolePagesMenu() {
      this.isRolePagesMenuOpen = !this.isRolePagesMenuOpen
    },

      // Investment menu
      isInvestmentPageMenuOpen: false,
      toggleInvestmentPageMenu() {
        this.isInvestmentPageMenuOpen = !this.isInvestmentPageMenuOpen
      },

  // Email menu
  isEmailPageMenuOpen: false,
  toggleEmailPageMenu() {
    this.isEmailPageMenuOpen = !this.isEmailPageMenuOpen
  },

    // Modal
    isAdduserOpen: false,
    trapCleanup: null,
    openAdduser() {
      this.isAdduserOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#adduser'))
    },
    closeAdduser() {
      this.isAdduserOpen = false
      this.trapCleanup()
    },

    isModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true
      // this.trapCleanup = focusTrap(document.querySelector('#Modal'))
    },
    closeModal() {
      this.isModalOpen = false
      // this.trapCleanup()
    },
    // view clients

    isViewSlientsOpen: false,
    trapCleanup: null,
    openViewSlients() {
      this.isViewSlientsOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#ViewSlients'))
    },
    closeViewSlients() {
      this.isViewSlientsOpen = false
      this.trapCleanup()
    },
  }
}

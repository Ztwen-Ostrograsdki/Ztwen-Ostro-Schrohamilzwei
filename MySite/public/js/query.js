var tabs = document.querySelectorAll('.maskor .navor a')
var menuActivator = document.querySelector('.maskor .menu-activator')
var menuSelf = document.querySelector('.maskor .navor .menu')
var addNow = document.getElementById('addNow')


// addNow.addEventListener('submit', function(e){
// 	var response = window.confirm("Voulez-vous ajouter une nouvelle catégories?")
// 	if (response === false) {
		
// 	}
// })

for (var i = 0; i < tabs.length; i++) {
	tabs[i].addEventListener('click', function(e){

		var maskor = this.parentNode.parentNode.parentNode

		if(!this.classList.contains('active')){
			var olderActive = document.querySelector('.maskor .navor a.active')
			olderActive.classList.remove('active')
			this.classList.add('active')
			this.classList.remove('hover')
			olderActive.classList.add('hover')
			
			if(this === menuSelf){
				menuActivator.classList.remove('fade')
				menuActivator.classList.remove('display-none')
				menuActivator.classList.add('move')
				
				menuActivator.addEventListener('animationend', function(){
					this.style.left = '10px'
				})	
			}

			if(this !== menuSelf && olderActive == menuSelf){
				menuActivator.classList.remove('move')
				menuActivator.classList.add('fade')
				menuActivator.addEventListener('transitionend', function(){
					menuActivator.style.left = '-200px'
				})
				
			}
		}
	})
}


var hash = window.location.hash 
console.log(hash)




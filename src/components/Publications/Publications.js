import React from 'react'
import './Publications.css'

function Publications() {
  return (
    <div class='publications_outer_shell'>

    <div class='publications_top_background'>
            <div class='publications_top'>       
                <h2>Relational Publications</h2>
                <div class='publications_top_inner'>
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac elit leo. Donec sit amet pharetra nunc, sit amet tincidunt lorem. Morbi vel justo eu leo finibus commodo a at lectus. Mauris non est feugiat, dapibus ipsum ultrices, viverra lorem. 
                    </p>
                </div>
            </div>
    </div>
    
    
    
    
    
    <div class='publications_mid_page'>
    
        <div class='publication_one_container'>
             <div class='publication_one_text'>
                    <h3>Dialouge for Democracy</h3>
                    <p>Deepening relationship through dialogue; skills for democracy. This Handbook from The Center for RelationaLearning provides multiple activities to support open, accepting and democratic discussion among participants. </p>
                    <p>Written by: Dr. George Otero, Stephen Preskill and Lois Vermilya</p>
    
                        <div class='publications_price_container'>
                                        <span>$34.99 USD</span> 
                                        <a href='https://www.learndesk.us/product/4832511445172224/dialogue-for-democracy'>
                                        <button class='publications_button'>Buy Now</button>
                                        </a>
                        </div>
                    </div>
    
                <div class='publication_one_book_container'>
                            <img class='publication_one' src='https://dev.relationalearning.com/wp-content/uploads/2024/03/Democracy-Cover.png' alt=''/>
                </div>
    
                </div>
    
    
                
    
                
    
        </div>
    
        </div>
  )
}

export default Publications
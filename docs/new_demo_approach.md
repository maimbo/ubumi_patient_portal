# Move to using IndexedDB for Demo
- I am NOW transitioning to using IndexedDB for demonstrating full-circle CRUD features of my application
- 

# Motivation and Aims of New Approach
- I want to easily utilise my skills as a back-end developer who mainly develops with traditional server-side languages like PHP, C# interacting with databases like MySQL and SQL Server.
- However, this time I need to utilise my skills in an HTML-JavaScript application with no server-side language
- I want to have a demo version of application, that is the HTML-Javascript version without server-side languages and full database access of MySQL or SQL Server 
- I want to remove the overhead of managing and accessing a seperate database management system and instead use IndexedDB in a relational kind of way
- So I need to combine the best of both worlds, with easy-setup of IndexedDB combined with best of relational data access

# Your Reference Data
- You need to closely analyse the JSON data files in the data folder to understand how I intend to structure my application data  
- I think I will try to model relationships of my data using IndexedDB.. You need you to create a robust way of accessing and editing records across different categories of a patient in IndexedDB
- Keep in mind the overall context of the system I am building, is a National Centralised Patient Portal, so there are different health providers with various care plans, etc and the data modelling needs to clearly reflect this
- read through the files prefixed with - understand_system_<<numberr>><<context>>.md in the docs folder to understand the system context and requirements


# Where I am
- I started something with another AI agent but I faced too many errors. I think you will defintely do much better
- First thing is to resolve issues in the IndexedDb data service class. I think best you go for some reliable, trusted package rather than re-inevnt the wheel
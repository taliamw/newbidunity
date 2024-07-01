# BidUnity: A Web-based Application Empowering Joint Investors through Collaborative Auctions for Shared Properties

## Description
This web app revolutionizes online auctions by enabling joint investment projects for shareable assets like real estate and business shares. It addresses financial barriers faced by individual investors in traditional auction systems, promoting inclusivity and fair access to valuable properties. The platform allows individuals and companies to pool resources for group bids, with ownership stakes allocated proportionally based on contribution. Designed for user-friendliness and security, informed by market research and user feedback. Aims to democratize asset access, fostering a more inclusive and equitable online auction environment.

## Built with
* [Laravel](https://laravel.com/docs/11.x)
* [Laravel Jetsream](https://jetstream.laravel.com/introduction.html)

## Set up and deploy
### Prerequisites
1. PHP installed on your system (version 7.4 or higher recommended)
2. Composer globally installed
3. Node.js and npm installed
4. MySQL or another compatible database installed
5. Git installed

#### 1. Clone the repository
    git clone https://github.com/taliamw/newbidunity.git
    cd newbidunity

#### 2. Install PHP dependecies
    composer install
    
#### 3. Install Node.js Dependencies
    npm install
    
#### 4. Set Environment Variables
Create a copy of the .env.example file and rename it to .env. Update the database connection settings and other necessary variables.

#### 5. Generate Application Key
    php artisan key:generate
    
#### 6. Database Migration
    php artisan migrate
    
#### 7. Compile Assets
    npm run dev
    
#### 8. Run the Application
    php artisan serve

## Project Structure
The project structure is documented in the [project_structure.txt](project_structure.txt) file.

## Contibutors
* [Natalia Mwangi](https://github.com/taliamw)
* [Michael Mirieri](https://github.com/MirieriMichael)

## Licenses
* MIT License
* [BootstrapeMade](https://bootstrapmade.com/license/)

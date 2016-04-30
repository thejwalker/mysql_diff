# mysql_diff
A simple tool to identify differences among two mysql databases including tables, rows and fields.  By setting db connection info this will compare both databases and indicate where any major differences exist.  I built this tool to help create efficiencies between developing locally, pushing to a staging server then to a production server.


***DO NOT USE THIS IN A PUBLIC FACING ENVIRONMENT***
> 
> For obvious reasons this tool should not be made available to any public users as it will not only display sensitive information about your database schema but it is also not very security conscious at the moment.  It is intended only for private localized development use.

![SCREENSHOT](https://monosnap.com/file/7mcr63mDNgAKAYTrLhTsd0gxo0xDl6.png)	
# How To Use

1. Download all of the contents to a folder within your local document path.
2. Configure db.settings.ini with the login credentials of DB1 and DB2 that you wish to compare
	
	**[db1]**	
	host=localhost	
	dbname=		
	username=			
	password=	
		
	**[db2]**		
	host=localhost	
	dbname=		
	username=	
	password=		
	
3. Open the main index page in your browser: <http://localhost:8888/mysql_compare>


**I would love some help from anyone that may wish to contribute to this project**	

I hope that you find it useful.

<jon@aristoworks.com> - Twitter: [@aristoworks](http://twitter.com/aristoworks)	
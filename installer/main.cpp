#include <QCoreApplication>
#include <QDebug>
#include <QStringList>
#include <QTextStream>
#include <QFile>
#include <QSqlDatabase>
#include <QSqlQuery>

#include <stdlib.h>

#define StdOut QTextStream(stdout)

extern "C"
{
    #include <readline/readline.h>
}

typedef QPair<QByteArray,QByteArray> bytearraypair;


#define RESDIR   "/home/aep/restore/installer/res/"
#define SKEL     "/home/aep/restore/*"
#define TARGET   "/home/"
#define TARGET_B   "/html/restore/"

#define SQLPWD ""
#define VHOSTS   "/tmp/http/vhosts/"

void die()
{
    qDebug()<<"\n\n\n/!\\ FAILURE /!\\\nNichts anfassen, die maschine ist nicht in zuverlaessigem Zustand.\n/!\\ FAILURE /!\\\n ";
    abort();
}

void systemEx(QByteArray command)
{
    if(system(command.constData())!=0)
    {
        die();
    }
}



int addShop(QString user)
{

    QMap<QByteArray,QByteArray> installerValues;
    QList<QPair<QByteArray,QByteArray> >  nameMapping;


    nameMapping<<bytearraypair("DOMAIN","domain name (without the wwww)");
    nameMapping<<bytearraypair("UNIXUSER","new unix user name");
    nameMapping<<bytearraypair("COMPANY_NAME","company name");
    nameMapping<<bytearraypair("OWNER_FIRST_NAME","Shop owners first name");
    nameMapping<<bytearraypair("OWNER_LAST_NAME","Shop owners last name");
    nameMapping<<bytearraypair("OWNER_STREET","Shop owners street address");
    nameMapping<<bytearraypair("OWNER_POSTCODE","Shop owners post code");
    nameMapping<<bytearraypair("OWNER_CITY","Shop owners city");
    nameMapping<<bytearraypair("STORE_NAME","Name of the shop");
    nameMapping<<bytearraypair("STORE_MAIL","Mail address of the shop system");
    nameMapping<<bytearraypair("OWNER_MAIL","Mail address of the shop owner");
    nameMapping<<bytearraypair("PWD","Admin Password");


    foreach(bytearraypair name,nameMapping)
    {
        if(name.first=="UNIXUSER")
        {
            installerValues[name.first]=user.toAscii();
            continue;
        }
        installerValues[name.first]=readline((name.second+": ").constData());
    }

    StdOut<<"\n\nPlease double check your input.\n\n";

    foreach(bytearraypair name,nameMapping)
    {
        StdOut<<name.second+": "<<installerValues[name.first]<<endl;
    }

    StdOut<<"\nPress Enter to start the installation progress with the values above or press Ctrl+C to cancel.\nDo not Cancel during installation\nDouble check your values!! You risk corupting the entire machine. The values are NOT checked by this program. You have been warned.\n";

    readline("");







    {
        StdOut<<"\n\n===>add unix user\n";

        systemEx("useradd -m -s /bin/false "+installerValues["UNIXUSER"]);
        systemEx ("mkdir -p " TARGET + installerValues["UNIXUSER"] + TARGET_B);
    }

    {
        StdOut<<"\n\n===>copy store from skel\n";
        systemEx("cp -av " SKEL " " TARGET "/"  + installerValues["UNIXUSER"] + TARGET_B );
        StdOut<<"\n\n===>configure app\n";

        QFile f1(RESDIR "/app_conf.php");
        StdOut<<".f1\n";
        if(!f1.open(QFile::ReadOnly))die();

        QByteArray xk1=f1.readAll();
        foreach(QByteArray key,installerValues.keys())
        {
            xk1.replace("<<RSTI_"+key+">>",installerValues[key]);
        }
        QFile t1(TARGET  + installerValues["UNIXUSER"] + TARGET_B+ "/app/includes/configure.php");
        StdOut<<".t1\n";
        if(!t1.open(QFile::WriteOnly| QFile::Truncate))die();
        t1.write(xk1);

        StdOut<<"\n\n===>configure admin\n";

        QFile f2(RESDIR "/admin_conf.php");
        StdOut<<".f2\n";
        if(!f2.open(QFile::ReadOnly))die();

        QByteArray xk2=f2.readAll();
        foreach(QByteArray key,installerValues.keys())
        {
            xk2.replace("<<RSTI_"+key+">>",installerValues[key]);
        }
        QFile t2(TARGET  + installerValues["UNIXUSER"] +TARGET_B+ "/admin/includes/configure.php");
        StdOut<<".t2\n";
        if(!t2.open(QFile::WriteOnly| QFile::Truncate))die();
        t2.write(xk2);


    }
    {
        StdOut<<"\n\n===>sql configure\n";
        QFile f(RESDIR "/restore.sql");
        f.open(QFile::ReadOnly);
        QString xk=f.readAll();
        foreach(QByteArray key,installerValues.keys())
        {
            xk.replace("<<RSTI_"+key+">>",installerValues[key]);
        }
        StdOut<<"\n\n===>sql connect\n";

            QSqlDatabase db = QSqlDatabase::addDatabase("QMYSQL");
            db.setHostName("localhost");
            db.setUserName("root");
            db.setPassword(SQLPWD);
            if(!db.open())die();

        StdOut<<"\n\n===>sql create\n";
            if(!QSqlQuery().exec("create database `"+installerValues["UNIXUSER"]+"`; "))die();
        StdOut<<"\n\n===>sql grant\n";
            if(!QSqlQuery().exec("grant ALL on "+installerValues["UNIXUSER"]+".* to '"+installerValues["UNIXUSER"]+"'@'%' identified by '"+installerValues["PWD"]+"';"))die();
        StdOut<<"\n\n===>sql flush\n";
            if(!QSqlQuery().exec("flush PRIVILEGES;"))die();
        StdOut<<"\n\n===>sql insert\n";
            if(!QSqlQuery().exec("use  `"+installerValues["UNIXUSER"]+"`; \n"+xk))die();

    }
    {
        StdOut<<"\n\n===>configure vhost\n";

        QFile f1(RESDIR "/vhost");
        StdOut<<".f1\n";
        if(!f1.open(QFile::ReadOnly))die();

        QByteArray xk1=f1.readAll();
        foreach(QByteArray key,installerValues.keys())
        {
            xk1.replace("<<RSTI_"+key+">>",installerValues[key]);
        }
        QFile t1(VHOSTS  + installerValues["UNIXUSER"]);
        StdOut<<".t1\n";
        if(!t1.open(QFile::WriteOnly| QFile::Truncate))die();
        t1.write(xk1);
    }

    StdOut<<"\n\nall good. now restart apache.\n";
    return 0;
}



int deleteShop(QString user)
{
    QByteArray u=user.toAscii();

    readline("delete the user. are you sure? ");


    StdOut<<"\n\n===>delete useraccount\n";
    systemEx("userdel -f "+u);

    StdOut<<"\n\n===>delete shop\n";
    systemEx ("rm -rf " TARGET + u);

    StdOut<<"\n\n===>delete vhost\n";
    systemEx ("rm     " VHOSTS + u);


    StdOut<<"\n\n===>sql connect\n";

    QSqlDatabase db = QSqlDatabase::addDatabase("QMYSQL");
    db.setHostName("localhost");
    db.setUserName("root");
    db.setPassword(SQLPWD);
    if(!db.open())die();

    StdOut<<"\n\n===>sql drop\n";
        if(!QSqlQuery().exec("drop database `"+u+"`; "))die();

    StdOut<<"\n\nall good. now restart apache.\n";
    return 0;
}


int listShops()
{
    return system("ls " VHOSTS);
    
}


int backupShop(QString user)
{
    
    systemEx("mysqldump "+ user.toAscii());

    return 0;
}


int main(int argc, char ** argv)
{
    QCoreApplication app(argc,argv);


    if(app.arguments().count()>2)
    {
        if(app.arguments().at(1)=="-a")
            return addShop(app.arguments().at(2));
        if(app.arguments().at(1)=="-d")
            return deleteShop(app.arguments().at(2));
        if(app.arguments().at(1)=="-b")
            return backupShop(app.arguments().at(2));
    }
    if(app.arguments().count()>1)
    {
        if(app.arguments().at(1)=="-l")
            return listShops();
    }

    StdOut
    <<" _     _ _            _                      _      "<<endl
    <<"| |   (_) |_ ___  ___| |_ ___  _ __ ___   __| | ___ "<<endl
    <<"| |   | | __/ _ \\/ __| __/ _ \\| '__/ _ \\ / _` |/ _ \\"<<endl
    <<"| |___| | ||  __/\\__ \\ || (_) | | |  __/| (_| |  __/"<<endl
    <<"|_____|_|\\__\\___||___/\\__\\___/|_|  \\___(_)__,_|\\___|"<<endl
    <<endl
    <<"This is the restore install helper."<<endl<<endl
    <<"-a <user>          add"<<endl
    <<"-d <user>          delete"<<endl
    <<"-s <user>          suspend"<<endl
    <<"-b <user>          backup"<<endl
    <<"-l              list users"<<endl

    <<endl;

    return 0;
};




// server_connect()

global.BUFFER = buffer_create()

SOCKET = socket_create()

socket_connect(SOCKET, global.IP, global.PORT);

send_auth();

Connected = false;

net_id = -1;

brickCount = 0;

bricksDownloaded = false

alive = false;

xPos = 0;
yPos = 0;
zPos = 0;
xRot = 0;
yRot = 0;
zRot = 0;
xScale = 1;
yScale = 1;
zScale = 1;
Arm = -1;
toolNum = 0;
maxHealth = 100;
Health = maxHealth;
partColorHead = 0;
partColorTorso = 0;
partColorRArm = 0;
partColorLArm = 0;
partColorRLeg = 0;
partColorLLeg = 0;
partStickerFace = "0";
partStickerTShirt = "0";
partStickerShirt = "0";
partStickerPants = "0";
partModelHat1 = "0";
partModelHat2 = "0";
partModelHat3 = "0";
Score = 0;
maxJumpHeight = 5;
FOV = 60;
CamDist = 10;
CamXPos = 0;
CamYPos = -50;
CamZPos = 50;
CamXRot = 0;
CamYRot = -20;
CamZRot = 0;
CamType = "fixed"; //("fixed", "orbit", "free", "first")
CamObj = -1;
team = -1;
Weather = "sun";

Item = -1;
Item_Tex = -1;
Item_TexDownload = -1;
Item_ModDownload = -1;

NpCamZRot = CamZRot;
pCamZRot = CamZRot;
zSpeed = 0;
JumpState = 0;

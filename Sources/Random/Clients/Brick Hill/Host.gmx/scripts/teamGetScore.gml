// teamGetScore(id team)
with argument0 {
    var T,totalScore;
    totalScore = 0;
    for(T = 0; T < numMembers; T += 1) {
        totalScore += playerGetScore(member[T]);
    }
    return totalScore;
}
return "";
